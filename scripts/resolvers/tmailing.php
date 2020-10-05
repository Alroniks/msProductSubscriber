<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('msinformuser_core_path', null,
                                          $modx->getOption('core_path') . 'components/msinformuser/') . 'model/';
            $modx->addPackage('msinformuser', $modelPath);
            $modx->lexicon->load('msinformuser:default');

            if ($modx->context && $modx->context->get('key') == 'mgr') {
                $defaultLanguage = $modx->getOption('manager_language',null, $modx->getOption('cultureKey', null, 'en'));
            } else {
                $defaultLanguage = $this->modx->getOption('cultureKey',null,'en');
            }

            $mailings = [
                1 => [
                    'name' => $defaultLanguage == 'ru' ? 'Страница ресурса' : 'Resource page',
                    'description' => $defaultLanguage == 'ru'
                        ? 'Рассылка со страниц ресурса админки, позволяет отправить 
                            письмо только на один адрес электронной почты, шаблон письма указывается здесь. 
                            Если отключить эту рассылку, то форма, на страницах ресурса, выводиться не будет.'
                        : 'Mailing from the pages of the resource admin allows you to send an 
                            email to only one email address, the email template is specified here. 
                            If you disable this newsletter, the form on the resource pages will not be displayed.',
                    'template' => 'msInformUserPlsExamplesTpl',
                ],
                2 => [
                    'name' => $defaultLanguage == 'ru' ? 'Сообщить о поступлении' : 'To announce the arrival of',
                    'description' => $defaultLanguage == 'ru'
                        ? 'Рассылка пользователям, которые ждут поступления товара.'
                        : 'Mailing to users who are waiting for the goods.',
                    'template' => 'msInformUserInformSendTpl',
                    'subject' => $defaultLanguage == 'ru' ? 'Ваш товар поступил' : 'Your item has arrived',
                ]
            ];

            foreach ($mailings as $index=> $properties) {
                if (!$status = $modx->getObject('msInformUserMailing', ['index' => $index])) {
                    $status = $modx->newObject('msInformUserMailing', array_merge([
                                                                                      'subject' => '',
                                                                                      'sender' => $modx->getOption('emailsender'),
                                                                                      'reply_to' => '',
                                                                                      'attachment' => '',
                                                                                      'editable' => 0,
                                                                                      'index' => $index,
                                                                                  ], $properties));
                    if ($chunk = $modx->getObject('modChunk', ['name' => $properties['template']])) {
                        $status->set('template', $chunk->get('id'));
                    }
                    $status->save();
                }
            }
            break;
    }
}
return true;
