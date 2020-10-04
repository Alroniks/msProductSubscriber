<?php

$_lang['area_msinformuser_main'] = 'Основные';
$_lang['setting_msinformuser_store_sent_msg'] = 'Хранить отправленные сообщения';
$_lang['setting_msinformuser_store_sent_msg_desc'] = 'Столько дней будет храниться информация 
    о успешной отправке сообщения, по умолчанию 30 дней. Если "0", то информация очищаться не будет - не рекомендуется.';
$_lang['setting_msinformuser_limit_send'] = 'Отправлять писем за раз';
$_lang['setting_msinformuser_limit_send_desc'] = 'Сколько отправлять писем за один проход.';
$_lang['setting_msinformuser_use_cron'] = 'Использовать cron';
$_lang['setting_msinformuser_use_cron_desc'] = 'Если "Да", то для рассылок писем будет использоваться cron.';
$_lang['setting_msinformuser_send_period'] = 'Период отправки писем';
$_lang['setting_msinformuser_send_period_desc'] = 'Если указан период, то письма будут отправляться в 
    указанный период, например: <strong>09-20</strong> - письма будут отправляться с 09-00 утра 
    до 20-00 вечера (время серверное).<br />Если эта настройка не нужна, просто игнорируйте.';

$_lang['area_msinformuser'] = 'Сообщить о поступлении';
$_lang['setting_msinformuser_request_count'] = 'Запрашивать количество';
$_lang['setting_msinformuser_request_count_desc'] = 'Будет запрашивать количество ожидаемого товара в 
    модальном окне "Сообщить о поступлении."';
$_lang['setting_msinformuser_count_handler_class'] = 'Класс обработчик ';
$_lang['setting_msinformuser_count_handler_class_desc'] = 'Класс обработчик остатков товара.';

$_lang['area_msinformuser_control'] = 'Оповещение до или после контрольной даты';
$_lang['setting_msinformuser_control_handler_class'] = 'Класс обработчик';
$_lang['setting_msinformuser_control_handler_class_desc'] = 'Класс обработчик, по умолчанию: msIuControlHandler.';
$_lang['setting_msinformuser_control_debug'] = 'Регистрировать ошибки';
$_lang['setting_msinformuser_control_debug_desc'] = 'Если включено, то все детали добавления в рассылку 
    будут регистрироваться в журнале ошибок.';

$_lang['area_msinformuser_show'] = 'Видимость полей на страницах ресурсов';
$_lang['setting_msinformuser_count_show'] = 'Количество';
$_lang['setting_msinformuser_count_show_desc'] = 'Если включить, то на страницах ресурсов будет показано поле "Количество"';
$_lang['setting_msinformuser_send_show'] = 'Отправить Email';
$_lang['setting_msinformuser_send_show_desc'] = 'Если включить, то на страницах ресурсов будет показано поле "Отправить Email"';
$_lang['setting_msinformuser_date_control_show'] = 'Контрольная дата';
$_lang['setting_msinformuser_date_control_show_desc'] = 'Включает поле выбора контрольной даты. Используется для отложенной рассылки';

$_lang['area_msinformuser_register'] = 'Регистрация при подписке';
$_lang['setting_msinformuser_register'] = 'Регистрировать при подписке';
//$_lang['setting_msinformuser_register_desc'] = 'Если "Да", то в форме подписки будет показан чекбокс';
