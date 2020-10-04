<?php
include_once 'setting.inc.php';

$_lang['msinformuser'] = 'msInformUser';
$_lang['msinformuser_menu_desc'] = 'Управление рассылками сайта.';
$_lang['msinformuser_settings'] = 'Настройка';
$_lang['msinformuser_menu_settings_desc'] = 'Настройка рассылок.';
$_lang['msinformuser_name'] = 'Название';
$_lang['msinformuser_description'] = 'Описание';
$_lang['msinformuser_subject'] = 'Тема письма';
$_lang['msinformuser_sender'] = 'Адрес почты';
$_lang['msinformuser_reply_to'] = 'Адрес для ответа';
$_lang['msinformuser_template'] = 'Шаблон';
$_lang['msinformuser_attachment'] = 'Файл';
$_lang['msinformuser_update'] = 'Редактировать';
$_lang['msinformuser_enable'] = 'Включить';
$_lang['msinformuser_disable'] = 'Отключить';
$_lang['msinformuser_remove'] = 'Удалить';
$_lang['msinformuser_remove_selected'] = 'Удалить выбранное';
$_lang['msinformuser_remove_confirm'] = 'Вы уверены, что хотите удалить эту запись?';
$_lang['msinformuser_remove_selected_confirm'] = 'Вы уверены, что хотите удалить эти записи?';
$_lang['msinformuser_add'] = 'Добавить';
$_lang['msinformuser_select_chunk'] = 'Выберите чанк';
$_lang['msinformuser_active'] = 'Активно';
$_lang['msinformuser_actions'] = 'Действия';
$_lang['msinformuser_send'] = 'Отправить';
$_lang['msinformuser_close'] = 'Закрыть';
$_lang['msinformuser_count'] = 'Количество';
$_lang['msinformuser_count_desc'] = 'Здесь вы можете указать количество, например для учёта остатков товара';
$_lang['msinformuser_unsubscribe'] = 'Отписаться';
$_lang['msinformuser_subscribe'] = 'Подписаться';
$_lang['msinformuser_status'] = 'Статус';
$_lang['msinformuser_senddate'] = 'Дата извещения';
$_lang['msinformuser_expect'] = 'Ожидает';
$_lang['msinformuser_informed'] = 'Извещён';
$_lang['msinformuser_err'] = 'Ошибка';
$_lang['msinformuser_queue'] = 'Очередь';
$_lang['msinformuser_sent'] = 'Отправлено';
$_lang['msinformuser_sent_msg'] = 'Здесь собраны все отправленные сообщения, со статусом 
    "Извещён". Эти сообщения будут храниться столько дней, сколько указано в системной 
    настройке <strong>msinformuser_store_sent_msg</strong>';
$_lang['msinformuser_attachments'] = 'Файл';
$_lang['msinformuser_class'] = 'Класс';

$_lang['msinformuser_announce_arrival'] = 'Сообщить о поступлении';
$_lang['msinformuser_add_arrival'] = 'Вы успешно подписаны на уведомление о поступлении этого товара. 
    Как только этот товар поступит, мы сообщим Вам на электронный адрес:';
$_lang['msinformuser_exist_arrival'] = 'Вы уже подписаны на уведомление о поступлении этого товара.';
$_lang['msinformuser_remove_arrival'] = 'Ваша подписка удалена.';
$_lang['msinformuser_waiting_admission'] = 'Жду поступления';
$_lang['msinformuser_consent'] = 'Я согласен на обработку моих персональных данных.';
$_lang['msinformuser_subject_arrival_2'] = 'Ваш товар поступил';

$_lang['msinformuser_mailing'] = 'Рассылка';
$_lang['msinformuser_mailing_msg'] = 'Настройка видов рассылки.<br />
    Отложенная рассылка протестирована и отлажена только до истечения контрольного срока, 
    т.е. "0", "-3", "-7" и т.д. - числа могут быть любые.<br />Рассылка после контрольного срока, 
    пока, не протестирована, её использование на ваш страх и риск.';
$_lang['msinformuser_mailing_start'] = 'Оповещать до/после (-/+) дней';
$_lang['msinformuser_mailing_start_desc'] = 'Например: "-7 - оповещать за 7 дней до контрольной даты". 
    "+7 - оповещать после 7 дней от контрольной даты." Если указать 0, то письмо будет отправлено 
    непосредственно в этот день, по умолчанию 0';
$_lang['msinformuser_mailing_control_date_field'] = 'Поле контрольной даты';
$_lang['msinformuser_mailing_control_date_field_desc'] = 'Поле, где хранится контрольная дата, 
    исходя из этой даты будут происходить оповещения до или после указанных дней. 
    Указывать как класс|поле. Если пусто, то по умолчанию: modResource | iu_control_date';
$_lang['msinformuser_mailing_send_email_field'] = 'Поле с email пользователя';
$_lang['msinformuser_mailing_send_email_field_desc'] = 'Поле с email пользователя, куда отправлять оповещение. 
    Указывать как класс|поле. Если пусто, то по умолчанию: modUserProfile | email';
$_lang['msinformuser_mailing_class'] = 'Класс обработчик';
$_lang['msinformuser_mailing_class_desc'] = 'Класс обработчик для управления этой рассылкой - msIuControlHandler';
$_lang['msinformuser_mailing_parents_res'] = 'ID родителей';
$_lang['msinformuser_mailing_parents_res_desc'] = 'Список родителей, через запятую, 
    для добавления их потомков в рассылку. У потомков должно быть заполнено поле контрольной даты.';

$_lang['msinformuser_mailing_groups'] = 'Группы рассылок';
$_lang['msinformuser_mailing_group'] = 'Группа';
$_lang['msinformuser_mailing_groups_msg'] = 'Группы рассылок используются для группировок отложенной рассылки.';
$_lang['msinformuser_create_groups'] = 'Сначало создайте группу';
$_lang['msinformuser_create_groups_desc'] = 'Чтобы добавить рассылку, необходимо создать хотя бы одну группу рассылок.';

$_lang['msinformuser_send_res'] = 'Страница ресурса';
$_lang['msinformuser_send_res_desc'] = 'Рассылка со страниц ресурса админки, позволяет отправить письмо только на один адрес электронной почты, шаблон письма указывается здесь. 
    Если отключить эту рассылку, то форма, на страницах ресурса, выводиться не будет.';
$_lang['msinformuser_send_inform'] = 'Сообщить о поступлении';
$_lang['msinformuser_send_inform_desc'] = 'Рассылка пользователям, которые ждут поступления товара.';
$_lang['msinformuser_send_success'] = 'Ваше сообщение отправлено!';
$_lang['msinformuser_open_send'] = 'Отправить Email';
$_lang['msinformuser_send_question'] = 'Будет отправлено письмо на адрес';
$_lang['msinformuser_send_success'] = 'Ваше сообщение отправлено!';

$_lang['msinformuser_date'] = 'Дата [msInformUser]';
$_lang['msinformuser_date_help'] = 'Дата для рассылок msInformUser, подробнее в документации.';

$_lang['msinformuser_mailing_err_ns'] = 'Не указана рассылка.';
$_lang['msinformuser_mailing_err_nf'] = 'Рассылка не найдена.';
$_lang['msinformuser_mailing_err_name'] = 'Вы должны указать имя рассылки.';
$_lang['msinformuser_mailing_err_ae'] = 'Рассылка с таким именем уже существует.';
$_lang['msinformuser_err_not_email'] = 'Вы забыли указать адрес электронной почты.';
$_lang['msinformuser_err_template_send'] = '<span style="color: red;">Вы не указали чанк для электронной почты.</span>';
$_lang['msinformuser_err_no_template'] = 'Указанный в настройках чанк, не найден.';
$_lang['msinformuser_err_tpl'] = '[msInformUser] Не указан чанк';
$_lang['msinformuser_err_separator'] = '[msInformUser] Нет сепаратора';
$_lang['msinformuser_err_email_validate'] = 'Адрес электронной почты должен быть в формате: user@domain.com';
$_lang['msinformuser_err_subscription_ns'] = 'Не указана подписка.';
$_lang['msinformuser_err_subscription_nf'] = 'Подписка не найдена.';
$_lang['msinformuser_err_start_mailing'] = 'Не указано за сколько или через сколько дней 
    оповещать пользователя';
