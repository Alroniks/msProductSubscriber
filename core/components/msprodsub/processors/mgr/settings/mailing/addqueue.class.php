<?php

class msInformUserDelayedProcessor extends modObjectProcessor
{
//    /** @var msInformUserArrival $object */
//    public $object;
//    public $update;
    public $objectType = 'msInformUserArrival';
    public $classKey = 'msInformUserArrival';
    public $languageTopics = ['msinformuser'];
    /** @var string modResource */
    protected $class = 'modResource';
    /** @var array $data */
    protected $data;
    /** @var integer $mailingIndex */
    protected $mailingIndex;
    /** @var integer $startMailing */
    protected $startMailing = 0;
    /** @var string $controlDateField */
    protected $controlDateField = 'iu_control_date';
    /** @var string $emailClass */
    protected $emailClass = 'modUserProfile';
    /** @var string $emailField */
    protected $emailField = 'email';


    /**
     * @return bool
     */
    public function initialize()
    {
        $this->object = $this->modx->newObject($this->classKey);

        $this->data = $this->modx->fromJSON($this->getProperty('data'));
        $group = trim($this->data['group']);
        if ($gr = $this->modx->getObject('msInformUserMailingGroup', ['name' => $group])) {
            $this->class = $gr->get('class');
        }

        return parent::initialize();
    }

    /**
     * @return bool|null|string
     */
    public function beforeSet()
    {
        $mailingIndex = (int) $this->data['id'];
        $startMailing = (int) $this->data['start_mailing'];
        $controlDateField = $this->data['control_date_field'];
        $sendEmailField = array_map('trim', explode('|', $this->data['send_email_field']));

        if (empty($mailingIndex)) {
            return $this->modx->lexicon('msinformuser_mailing_err_ns');
        } else {
            $this->mailingIndex = $mailingIndex;
        }
        if (!empty($startMailing)) {
            $this->startMailing = $startMailing;
        } elseif (!empty($controlDateField)) {
            $this->controlDateField = $controlDateField;
        } elseif (!empty($sendEmailField)) {
            $this->emailClass = $sendEmailField[0];
            $this->emailField = $sendEmailField[1];
        }

        return true;
    }


    public function process() {
        /** @var msInformUser $msInformUser */
        if (!$msInformUser = $this->modx->getService('msInformUser')) {
            print_r('no class');die;
        }

        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }
        // Получить данные для постановки в очередь
        $records = $this->getRecordsList();
        if (empty($records)) {
            return $this->failure($records);
        }
        // Получить очередь со статусом Ожидает (2)
        $expects = $this->getArrivalList();

        $total = 0;
        $updates = 0;
        $creates = 0;
        $error = 0;
        $logs = [];
        $msg = '';
        foreach ($records as $key => $record) {
            // От сегодняшнего дня
            $minDate = time();
            // От контрольной даты
            $maxDate = strtotime($this->startMailing . ' day',
                strtotime($record[$this->controlDateField]));

            if ($this->startMailing < 0 && $minDate > $maxDate) {
                continue;
            } elseif ($this->startMailing == 0 && $minDate > $maxDate) {
                continue;
            }

            if (in_array($record['id'], $expects)) {
                $result = $this->updateArrival($record['id'],
                    strtotime($record[$this->controlDateField]));

                if ($result === true) {
                    $total++;
                    $updates++;
                    $logs['updates'] = $updates;
                } elseif ($result === false) {
                    $error++;
                    $logs['errors'] = $error;
                    $logs['errors_update'][$key] = $record;
                }
            } else {
                if (empty($record['email'])) {
                    $error++;
                    $logs['errors'] = $error;
                    $logs['errors_create'][$key] = $record;
                    continue;
                }

                $total++;
                $creates++;
                $logs['creates'] = $creates;
                $logs['create'][$key] = $record;
                $properties = [
                    'res_id' => $record['id'],
                    'mailing_index' => $this->mailingIndex,
                    'title' => $record['pagetitle'],
                    'uri' => $record['uri'],
                    'createdon' => time(),
                    'senddate' => strtotime($this->startMailing . ' day', strtotime($record[$this->controlDateField])),
                    'email' => $record['email'],
                    'user_id' => $record['createdby'],
                    'status' => 1,
                ];

                /** msInformUserArrival $object */
                $object = $this->modx->newObject('msInformUserArrival');
                $object->fromArray($properties);
                $object->save();

            }
        }

        if ($this->modx->getOption('msinformuser_control_debug')) {
            $this->modx->log(MODx::LOG_LEVEL_ERROR, print_r($logs, 1));
        }

        if(!empty($updates)) {
            $msg .= ' Обновлено рассылок ' . $updates .'. ';
        }

        if(!empty($creates)) {
            $msg .= ' Добавлено рассылок ' . $creates . '. ';
        }

        if(!empty($error)) {
            return $this->failure('Ошибка при добавлении в рассылку. Все детали можно посмотреть в журнале ошибок, 
            если влючена системная настройка msinformuser_control_debug,');
        }

        if(empty($total)) {
            return $this->success('Все оповещения уже добавлены, обновлений не требуется');
        }

        return $this->success($this->modx->lexicon($msg, array(
            'total' => $total,
            'succeed' => $msg,
        )));
    }

    /**
     * @param $resId
     * @param $newDataSend
     * @return bool
     */
    public function updateArrival($resId, $newDataSend)
    {
        if ($update = $this->modx->getObject($this->classKey, [
            'res_id' => $resId,
            'status' => 1,
            'mailing_index' => $this->mailingIndex,
        ])) {
            $senddate = strtotime($this->startMailing . ' day', $newDataSend);
            if ($senddate == strtotime($update->get('senddate'))) {
                return null;
            }

            $update->set('senddate', $senddate);
            $update->set('updatedon', time());
            if ($update->save()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array|string
     */
    public function getRecordsList()
    {
        $c = $this->modx->newQuery($this->class, [$this->controlDateField . ':>' => 0 ]);
        $records = $this->modx->getIterator($this->class, $c);

        $tmp = [];
        /** @var $this->class $record */
        foreach ($records as $key => $record) {
            $tmp[$key] = $record->toArray();
            if ($this->class == 'modResource') {
                // modUserProfile email
                if ($this->emailClass == 'modUserProfile') {
                    $tmp[$key]['email'] = $record->getOne('CreatedBy')
                        ->getOne('Profile')->{$this->emailField};
                // msVendor email
                } elseif ($this->emailClass == 'msVendor') {
                    $email = $record->get('vendor.email');
                    if (!empty($email)) {
                        $tmp[$key]['email'] = $email;
                    }
                }
            }
        }

        if (empty($tmp)) {
            return 'Нет данных для постановки в очередь';
        }

        return $tmp;
    }

    /**
     * @return array
     */
    public function getArrivalList()
    {
        $c = $this->modx->newQuery($this->classKey, [
            'status' => 1,
            'mailing_index' => $this->mailingIndex,
        ]);
        $lists = $this->modx->getIterator($this->classKey, $c);

        $expects = [];
        foreach ($lists as $list) {
            $expects[] = $list->res_id;
        }

        return $expects;
    }
}

return 'msInformUserDelayedProcessor';