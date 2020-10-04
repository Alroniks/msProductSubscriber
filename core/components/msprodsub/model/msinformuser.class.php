<?php

class msInformUser
{
    public $version = '1.2';
    /** @var modX $modx */
    public $modx;
    /** @var pdoTools $pdoTools */
    public $pdoTools;
    /** @var msIuCountHandler $stockOut */
    public $stockOut;
    /** @var msIuControlHandler $controlOut  */
    public $controlOut;

    /**
     * Данные из сессии
     * @var array $scriptProperties */
    public $scriptProperties = [];
    /**
     * Пользователь авторизован
     * @var bool $userAuth */
    public $userAuth = false;
    /**
     * Данные пользователя. На тот случай, если указанный email в форме отличается
     * от email в профиле. Содержит в себе: email
     * @var array $userInform */
    public $userInform = [];
    /**
     * Показывать поле запроса кол-ва в модальном окне
     * @var bool $requestCount */
    public $requestCount;
    /**
     * Использовать cron
     * @var bool $useCron */
    public $useCron;
    /** @var string $classArrival */
    public $classArrival = 'msInformUserArrival';
    /** @var string $tpl */
    protected $tpl;
    /** @var string $context */
    protected $context;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/msinformuser/';
        $assetsUrl = MODX_ASSETS_URL . 'components/msinformuser/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'customPath' => $corePath . 'custom/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'actionUrl' => $assetsUrl . 'action.php',
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',

            'limitSend' => (int) $this->modx->getOption('msinformuser_limit_send', null, 10, true),
        ], $config);

        $this->modx->addPackage('msinformuser', $this->config['modelPath']);
        $this->modx->lexicon->load('msinformuser:default');

        if ($pdoTools = $this->modx->getService('pdoTools')) {
            $this->pdoTools = $pdoTools;
        }
    }

    /**
     *
     */
    public function initialize()
    {
        $this->_initMap();
        // examples msInformUser to extras.marabar.ru
        if ($_SERVER['SERVER_NAME'] == 'extras.marabar.ru' && isset($_SESSION['extrasMarabar']['msIUrequestCount'])) {
            $this->requestCount = $_SESSION['extrasMarabar']['msIUrequestCount'];
        } else {
            $this->requestCount = $this->modx->getOption('msinformuser_request_count', null, false, true);
        }
        $this->useCron = $this->modx->getOption('msinformuser_use_cron', null, false, true);
        $this->scriptProperties = $this->getSession();
        $this->context = $this->modx->context->key;
        $user = [];

        if ($this->isAuthenticated($this->context)) {
            $this->userAuth = true;
            $userId = $this->modx->user->id;
            $tmp = $this->getUser(['internalKey' => $userId]);
            $user['email'] = $tmp['profile']['email'];
            $user['id'] = $tmp['profile']['internalKey'];
        }
        if (isset($this->scriptProperties['user']['email']) && !empty($this->scriptProperties['user']['email'])) {
            $user = array_merge($this->scriptProperties['user'], $user);
        }
        if (!empty($user)) {
            $this->userInform['user'] = $user;
        }
        $this->tpl = $this->scriptProperties['chunks']['tpl'];
        $this->removeCollection();

        if ($this->loadClasses() && !$this->useCron) {
            $this->stockOut->get(); // Оповещение о поступлении товара
            if ($this->controlOut) {
                $this->controlOut->get(); // Контрольная дата
            }
        }
        return true;
    }

    /**
     * Обработка AJAX запросов
     * @param $action
     * @param array $data
     * @return array|null
     */
    public function handleRequest($action, array $data)
    {
        $this->initialize();
        $properties = $this->getProduct($data['id']);
        $tplModal = $this->scriptProperties['chunks']['tplModal'];

        if (!empty($this->userInform['user']['email'])) {
            $properties = array_merge($properties, $this->userInform, ['disabled' => 'disabled']);
        }

        $properties['count'] = (int) $data['iu_count'];
        $properties['requestCount'] = $this->requestCount;
        $properties['addedArrival'] = false;
        $properties['removeArrival'] = false;
        $response = null;

        switch ($action) {
            case 'iu/modal/show':
                if ($this->userAuth) {
                    $response = $properties['requestCount']
                        ? $this->success('', [
                            'tplModal' => $this->getChunk($tplModal, $properties),
                            'mode' => 'requestCount'
                        ])
                        : $response = $this->prepareResponse($tplModal, $properties);
                } else {
                    if (!$properties['user']['email']) {
                        $properties['consent'] = $this->modx->lexicon('msinformuser_consent');
                    }
                    $response = $properties['requestCount'] || !$properties['user']['email']
                        ? $this->success('', [
                            'tplModal' => $this->getChunk($tplModal, $properties),
                            'mode' => 'requestCount'
                        ])
                        : $response = $this->prepareResponse($tplModal, $properties);
                }
                break;

            case 'iu/add':
                if (!$email = $this->validateEmail($data['iu_email'])) {
                    return $this->error($this->modx->lexicon('msinformuser_err_email_validate'), [
                        'mode' => 'invalidEmail'
                    ]);
                }
                $properties['user']['email'] = $this->verifySessionEmail($data['iu_email']);
                $response = $this->prepareResponse($tplModal, $properties);
                break;

            case 'iu/add/count':
            case 'iu/modal/show/signed':
                $response = $this->prepareResponse($tplModal, $properties);
                break;

            case 'iu/remove':
                if ($this->removeObject($this->classArrival, [
                    'email' => $properties['user']['email'],
                    'res_id' => (int) $data['id'],
                ])) {
                    $properties['removeArrival'] = true;
                    $properties['iuMessage'] = $this->modx->lexicon('msinformuser_remove_arrival');
                    $response = $this->success('', [
                        'tplModal' => $this->getChunk($tplModal, $properties),
                        'button' => $this->parseChunkButton($this->tpl, 0, ['id' => $properties['product']['id']]),
                        'id' => $properties['product']['id'],
                        'mode' => 'removeArrival'
                    ]);
                } else {
                    $response = $this->error('');
                }
                break;

            default:
                $response = $this->error('');
        }
        return $response;
    }

    /**
     * @return bool
     */
    public function loadClasses()
    {
        // Подключение класса обработки "Сообщить о поступлении"
        if (!class_exists('msIuCountHandler')) {
            require_once dirname(__FILE__) . '/msinformuser/msiucounthandler.class.php';
        }
        $stockOutClass = $this->modx->getOption('msinformuser_count_handler_class');
        if ($stockOutClass != 'msIuCountHandler') {
            $this->loadCustomClasses('count');
        }
        $this->stockOut = new $stockOutClass($this, $this->config);
        if (!($this->stockOut instanceof $stockOutClass)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                'Could not initialize msInformUser handler class: "' . $stockOutClass . '"');

            return false;
        }

        // Подключение класса обработки "Оповещение до или после контрольной даты"
        if ($this->modx->getCount('msInformUserMailing', [
                'id:NOT IN' => [1, 2],
                'active' => 1,
            ])
        ) {
            if (!class_exists('msIuControlHandler')) {
                require_once dirname(__FILE__) . '/msinformuser/msiucontrolhandler.class.php';
            }
            $controlClass = $this->modx->getOption('msinformuser_control_handler_class');
            if ($controlClass != 'msIuControlHandler') {
                $this->loadCustomClasses('control');
            }
            $this->controlOut = new $controlClass($this, $this->config);
            if (!($this->controlOut instanceof $controlClass)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,
                    'Could not initialize msInformUser handler class: "' . $controlClass . '"');

                return false;
            }
        }

        return true;
    }

    /**
     *  Подключай собственные классы
     * @param $type
     */
    public function loadCustomClasses($type)
    {
        $type = strtolower($type);
        if ($files = scandir($this->config['customPath'] . $type)) {
            foreach ($files as $file) {
                if (preg_match('/.*?\.class\.php$/i', $file)) {
                    /** @noinspection PhpIncludeInspection */
                    include_once($this->config['customPath'] . $type . '/' . $file);
                }
            }
        }

        return;
    }

    /**
     * @param $tplModal
     * @param array $properties
     * @return array|null
     */
    private function prepareResponse($tplModal, array $properties)
    {
        $response = null;
        $data = [
            'res_id' => $properties['product']['id'],
            'title' => $properties['product']['pagetitle'],
            'uri' => $properties['product']['uri'],
            'thumb' => $properties['product']['thumb'],
            'createdon' => time(),
            'email' => $properties['user']['email'],
            'user_id' => $properties['user']['id'],
            'count' => $properties['count'],
        ];

        if (isset($properties['user']['email']) && !empty($properties['user']['email'])) {
            if (!$this->getObject($this->classArrival, [
                'res_id' => (int) $properties['product']['id'],
                'email' => $properties['user']['email'],
                'status:!=' => 2,
            ])) {
                if ($this->newObject($this->classArrival, $data)) {
                    $properties['addedArrival'] = true;
                    $properties['iuMessage'] = $this->modx->lexicon('msinformuser_add_arrival')
                        . ' ' . $properties['user']['email'];
                    $response = $this->success('', [
                        'tplModal' => $this->getChunk($tplModal, $properties),
                        'button' => $this->parseChunkButton($this->tpl, 0, ['id' => $properties['product']['id']]),
                        'id' => $properties['product']['id'],
                        'mode' => 'addedArrival'
                    ]);
                }
            } else {
                $properties['addedArrival'] = true;
                $properties['iuMessage'] = $this->modx->lexicon('msinformuser_exist_arrival');
                $response = $this->success('', [
                    'tplModal' => $this->getChunk($tplModal, $properties),
                    'mode' => 'addedArrival'
                ]);
            }
        }

        return $response;
    }

    /**
     * Валидация электоронной почты
     * @param $email
     * @return bool
     */
    public function validateEmail($email)
    {
        $response = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = true;
        }

        return $response;
    }

    /**
     * Очищает таблицу от старых отправленных уведомлений
     */
    public function removeCollection()
    {
        $removeDay = (int) $this->modx->getOption('msinformuser_store_sent_msg');
        if ($removeDay > 0 && $this->modx->getCount('msInformUserArrival')) {
            $time = time() - 24*60*60 * $removeDay;
            $this->modx->removeCollection('msInformUserArrival', [
                'senddate:!=' => 0,
                'AND:senddate:<' => $time,
            ]);
        }

        return;
    }

    /**
     * @param $class
     * @param array $properties
     * @return bool
     */
    public function removeObject($class, array $properties = [])
    {
        $removed = false;
        if ($this->modx->removeObject($class, $properties)) {
            $removed = true;
        }

        return $removed;
    }

    /**
     * @param $class
     * @param array $properties
     * @return null|object
     */
    public function newObject($class, array $properties = [])
    {
        $instance = null;
        if ($instance = $this->modx->newObject($class, $properties)) {
            $instance->save();
        }

        return $instance;
    }

    /**
     * @param $class
     * @param array $properties
     * @return null|object
     */
    public function getObject($class, array $properties = [])
    {
        return $this->modx->getObject($class, $properties);
    }

    /**
     * @param $class
     * @param array $properties
     * @param array $fields
     */
    public function updateObject($class, array $properties = [], array $fields)
    {
        if ($object = $this->getObject($class, $properties)) {
            $i = 0;
            foreach ($fields as $k => $field) {
                $object->set($field, $k);
                $i++;
            }
            $object->save();
        }
        return;
    }

    /**
     * Парсит чанк, и отдаёт необходимую кнопку
     *
     * @param $chunkName
     * @param $iuCount
     * @param array $properties
     * @return null
     */
    public function parseChunkButton($chunkName, $iuCount, array $properties = [])
    {
        $chunk = $this->getChunk($chunkName, $properties);
        $arrival = $this->getObject($this->classArrival, [
            'res_id' => $properties['id'],
            'email' => $this->userInform['user']['email'],
            'status:!=' => 2,
        ]);
        $response = null;

        if (stripos($chunk, '<!--msInformUser-->')) {
            $buttons = explode('<!--msInformUser-->', $chunk);
            if ($iuCount < 1) {
                $response = $arrival ? $buttons[2] : $buttons[1];
            } else {
                $response = $buttons[0];
            }
        }
        return $response;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $_SESSION['msInformUser'];
    }

    /**
     * @param array $list
     */
    public function prepareSending(array $list = [])
    {
        $chunk = null;

        foreach ($list as $item) {
            $chunkName = $this->getNameChunk($item['mailing_template']);
            if (!empty($chunkName)) {
                $chunk = $this->getChunk($chunkName, $item);
            }

            if (!empty($chunk)) {
                $send = [
                    'to' => $item['arrival_email'],
                    'reply_to' => $item['mailing_reply_to'],
                    'body' => $chunk,
                    'sender' => $item['mailing_sender'],
                    'from_name' => $this->modx->getOption('site_name'),
                    'subject' => $item['mailing_subject'],
                    'attachment' => MODX_BASE_PATH . $item['attachment'],
                ];

                $result = $this->sendEmail($send);
                if (isset($result['result'])) {
                    $this->updateObject('msInformUserArrival', [
                        'id' => $item['arrival_id']
                    ],[
                        3 => 'status',
                        time() => 'updatedon',
                    ]);
                } else {
                    $this->updateObject('msInformUserArrival', [
                        'id' => $item['arrival_id']
                    ],[
                        2 => 'status',
                        time() => 'senddate',
                    ]);
                }
                unset($item, $send);
            } else {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, $this->modx->lexicon('msinformuser_err_tpl'));
                continue;
            }
        }
        return;
    }

    /**
     * Отправка почты
     *
     * @param array $send
     * @return array|bool
     */
    public function sendEmail(array $send) {
        if (!isset($send['from_name']) || empty($send['from_name'])) {
            $send['from_name'] = $this->modx->getOption('site_name');
        }

        /** @var modPHPMailer $mail */
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');

        $mail->setHTML(true);
        $mail->address('to', $send['to']);
        if (isset($send['reply_to']) && !empty($send['reply_to'])) {
            $mail->address('reply-to', $send['reply_to']);
        }
        $mail->set(modMail::MAIL_BODY, $send['body']);
        $mail->set(modMail::MAIL_FROM, $send['sender']);
        $mail->set(modMail::MAIL_FROM_NAME, $send['from_name']);
        $mail->set(modMail::MAIL_SUBJECT, $send['subject']);
        $mail->attach($send['attachment']);
        if (!$mail->send()) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'An error occurred while trying to send the email: '
                . $mail->mailer->ErrorInfo);
            $mail->reset();
            $result = [];
            $result['result'] = false;
            $result['messages'] = $mail->mailer->ErrorInfo;
            return $result;
        } else {
            $mail->reset();
            return true;
        }
    }

    /**
     * @param $chunkName
     * @param array $properties
     * @return mixed
     */
    public function getChunk($chunkName, array $properties = [])
    {
        $chunk = null;
        if ($this->pdoTools) {
            $chunk = $this->pdoTools->getChunk($chunkName, $properties);
        } else {
            $chunk = $this->modx->getChunk($chunkName, $properties);
        }
        return $this->_parserTag($chunk);
    }

    /**
     * Получает имя чанка
     *
     * @param $chunkId
     * @return bool|string
     */
    public function getNameChunk($chunkId)
    {
        $chunk = $this->modx->getObject('modChunk', $chunkId);
        if (!$chunk || !($chunk instanceof modChunk)) {
            return false;
        }
        return $chunk->name;
    }

    /**
     * Получает все поля объектов modResource, и если есть msProductData
     *
     * @param $id
     * @return array
     */
    public function getProduct($id)
    {
        $scriptProperties = [];

        $q = $this->modx->newQuery('modResource', (int) $id);
        $data = $this->modx->getIterator('modResource', $q);

        $data->rewind();
        if ($data->valid()) {
            foreach ($data as $k => $v) {
                $scriptProperties['product'] = $v->toArray();
            }
        }
        return $scriptProperties;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getUser(array $data = [])
    {
        $scriptProperties = [];
        if ($profile = $this->modx->getObject('modUserProfile', $data)) {
            $user = $profile->getOne('User');

            $scriptProperties['user'] = $user->toArray();
            $scriptProperties['profile'] = $profile->toArray();
        }
        return $scriptProperties;
    }

    /**
     * Проверяет введённый email на идентичность, хранящийся в сессии.
     * Если ложно, то записывает новый и возвращает его.
     *
     * @param $email
     * @return mixed
     */
    private function verifySessionEmail($email)
    {
        $properties = $this->scriptProperties;
        if (!isset($properties['user']['email']) || empty($properties['user']['email'])) {
            $_SESSION['msInformUser']['user']['email'] = $email;
        } else if ($properties['user']['email'] != $email) {
            $_SESSION['msInformUser']['user']['email'] = $email;
        }
        return $email;
    }

    /**
     *
     */
    private function _initMap()
    {
        $map = array(
            'modResource' => array(
                'fields' => array(
                    'iu_email' => '',
                    'iu_count' => 0,
                    'iu_control_date' => 0,
                ),
                'fieldMeta' => array(
                    'iu_email' => array (
                        'dbtype' => 'varchar',
                        'precision' => '100',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => '',
                    ),
                    'iu_count' => array (
                        'dbtype' => 'int',
                        'precision' => '10',
                        'phptype' => 'integer',
                        'null' => true,
                        'default' => 0,
                    ),
                    'iu_control_date' => array (
                        'dbtype' => 'int',
                        'precision' => '20',
                        'phptype' => 'timestamp',
                        'null' => false,
                        'default' => 0,
                    ),
                ),
            ),
        );

        foreach ($map as $class => $data) {
            $this->modx->loadClass($class);
            foreach ($data as $tmp => $fields) {
                if ($tmp == 'fields') {
                    foreach ($fields as $field => $value) {
                        foreach (array(
                                     'fields',
                                     'fieldMeta',
                                     'indexes',
                                     'composites',
                                     'aggregates',
                                     'fieldAliases',
                                 ) as $key) {
                            if (isset($data[$key][$field])) {
                                $this->modx->map[$class][$key][$field] = $data[$key][$field];
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $context
     * @return bool
     */
    public function isAuthenticated($context = 'web')
    {
        return $this->modx->user->isAuthenticated($context);
    }

    /**
     * @param string $message
     * @param array $data
     * @return array
     */
    public function success($message = '', $data = array())
    {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message),
            'data' => $data,
        );
        return $response;
    }

    /**
     * @param string $message
     * @param array $data
     * @return array
     */
    public function error($message = '', $data = array())
    {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message),
            'data' => $data,
        );
        return $response;
    }

    /**
     * @param $content
     * @return mixed
     */
    private function _parserTag($content)
    {
        $this->modx->getParser()
            ->processElementTags('', $content, false, false, '[[', ']]', array(), 10);
        $this->modx->getParser()
            ->processElementTags('', $content, true, true, '[[', ']]', array(), 10);
        return $content;
    }
}