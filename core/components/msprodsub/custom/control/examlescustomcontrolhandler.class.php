<?php
/**
 * Пример расширения класса msIuControlHandler
 *
 * Данный пример отправляет копию письма администратору.
 * Оригинал предупреждает пользователя о сроке истечения какого-то события
 *
 * Class examplesCustomControlHandler
 */

class examplesCustomControlHandler extends msIuControlHandler
{
    /**
     * @return array|bool|void
     */
    public function get()
    {
        parent::get();

        if (empty($this->list) && !is_array($this->list)) {
            return;
        }
        // Чанк письма администратору
        $chunkName = 'msInformUserEmailTpl';
        // Email получателя
        $to = '';

        foreach ($this->list as $list) {
            if (!empty($chunkName)) {
                $chunk = $this->msInformUser->getChunk($chunkName, $list);
            }

            if (!empty($chunk)) {
                $send = [
                    'to' => $to, // Получатель
                    'reply_to' => $list['mailing_reply_to'],
                    'body' => $chunk,
                    'sender' => $list['mailing_sender'],
                    'from_name' => $this->modx->getOption('site_name'),
                    'subject' => 'Копия уведомления', //$list['mailing_subject'], Тема письма
//                    'attachment' => MODX_BASE_PATH . $list['attachment'],
                ];

                $this->msInformUser->sendEmail($send);

                unset($list, $send);
            } else {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, $this->modx->lexicon('msinformuser_err_tpl'));
                continue;
            }
        }

        return;
    }
}