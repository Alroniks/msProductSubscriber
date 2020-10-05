<?php

include_once 'setting.inc.php';

$_lang['msinformuser'] = 'msInformUser';
$_lang['msinformuser_menu_desc'] = 'Management of site mailings.';
$_lang['msinformuser_settings'] = 'Settings';
$_lang['msinformuser_menu_settings_desc'] = 'Setting up mailings.';
$_lang['msinformuser_name'] = 'Name';
$_lang['msinformuser_description'] = 'Description';
$_lang['msinformuser_subject'] = 'Message subject';
$_lang['msinformuser_sender'] = 'Email address';
$_lang['msinformuser_reply_to'] = 'Reply-to address';
$_lang['msinformuser_template'] = 'Template';
$_lang['msinformuser_attachment'] = 'File';
$_lang['msinformuser_update'] = 'Edit';
$_lang['msinformuser_enable'] = 'Enable';
$_lang['msinformuser_disable'] = 'Disable';
$_lang['msinformuser_remove'] = 'Remove';
$_lang['msinformuser_remove_selected'] = 'Delete selected';
$_lang['msinformuser_remove_confirm'] = 'Are you sure you want to delete this record?';
$_lang['msinformuser_remove_selected_confirm'] = 'Are you sure you want to delete these records?';
$_lang['msinformuser_add'] = 'Add';
$_lang['msinformuser_select_chunk'] = 'Select chunk';
$_lang['msinformuser_active'] = 'Actively';
$_lang['msinformuser_actions'] = 'Actions';
$_lang['msinformuser_send'] = 'Send';
$_lang['msinformuser_close'] = 'Close';
$_lang['msinformuser_count'] = 'Count';
$_lang['msinformuser_count_desc'] = 'Here you can specify the quantity, for example, to post the product balances';
$_lang['msinformuser_unsubscribe'] = 'Unsubscribe';
$_lang['msinformuser_subscribe'] = 'Subscribe';
$_lang['msinformuser_status'] = 'Status';
$_lang['msinformuser_senddate'] = 'Date of notice';
$_lang['msinformuser_expect'] = 'Expects';
$_lang['msinformuser_informed'] = 'Notified';
$_lang['msinformuser_err'] = 'Error';
$_lang['msinformuser_queue'] = 'Queue';
$_lang['msinformuser_sent'] = 'Sent';
$_lang['msinformuser_sent_msg'] = 'Here are all the sent messages with a status of 
    "Notified." These messages will be stored for as many days as specified in the system 
    setting <strong>msinformuser_store_sent_msg</strong>';

$_lang['msinformuser_announce_arrival'] = 'To announce the arrival of';
$_lang['msinformuser_add_arrival'] = 'You have successfully subscribed to the notification of the receipt of the product. 
    As soon as this product arrives, we will notify you by e-mail:';
$_lang['msinformuser_exist_arrival'] = 'You are already subscribed to the receipt notice for this item.';
$_lang['msinformuser_remove_arrival'] = 'Your subscription has been removed.';
$_lang['msinformuser_waiting_admission'] = 'Waiting for admission';
$_lang['msinformuser_consent'] = 'I agree to the processing of my personal data.';
$_lang['msinformuser_subject_arrival_2'] = 'Your item has arrived';

$_lang['msinformuser_mailing'] = 'Mailing';
$_lang['msinformuser_mailing_msg'] = 'Setting up distribution types';

$_lang['msinformuser_send_res'] = 'Resource page';
$_lang['msinformuser_send_res_desc'] = 'Mailing from the pages of the resource admin allows you to send an email to only one email address, the email template is specified here. 
    If you disable this newsletter, the form on the resource pages will not be displayed.';
$_lang['msinformuser_send_inform'] = 'To announce the arrival of';
$_lang['msinformuser_send_inform_desc'] = 'Mailing to users who are waiting for the goods.';
$_lang['msinformuser_send_success'] = 'Your message has been sent!';
$_lang['msinformuser_open_send'] = 'Send Email';
$_lang['msinformuser_send_question'] = 'An email will be sent to';
$_lang['msinformuser_send_success'] = 'Your message has been sent!';

$_lang['msinformuser_mailing_err_ns'] = 'No mailing list specified.';
$_lang['msinformuser_mailing_err_nf'] = 'Mailing not found.';
$_lang['msinformuser_mailing_err_name'] = 'You must specify the name of the distribution.';
$_lang['msinformuser_mailing_err_ae'] = 'A mailing list with this name already exists.';
$_lang['msinformuser_err_not_email'] = 'You forgot to enter your email address.';
$_lang['msinformuser_err_template_send'] = '<span style="color: red;">You have not specified a chunk for email.</span>';
$_lang['msinformuser_err_no_template'] = 'Specified in the settings chunk, not found.';
$_lang['msinformuser_err_tpl'] = '[msInformUser] No chunk specified';
$_lang['msinformuser_err_separator'] = '[msInformUser] No separator';
$_lang['msinformuser_err_email_validate'] = 'The email address must be in the format: user@domain.com';
$_lang['msinformuser_err_subscription_ns'] = 'No subscription specified.';
$_lang['msinformuser_err_subscription_nf'] = 'The subscription was not found.';
