<?php
/** @var modX $modx */
/** @var msInformUser $msInformUser */
if (empty($_REQUEST['action']) || !empty($_REQUEST['data']['iu_val'])) {
    die('Access denied');
} else {
    $action = $_REQUEST['action'];
    $data = $_REQUEST['data'];
    unset($data['iu_val']);
}

define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    $modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'),'','','full'));
}

$msInformUser = $modx->getService('msinformuser', 'msInformUser', $modx->getOption('msinformuser_core_path', null,
        $modx->getOption('core_path') . 'components/msinformuser/') . 'model/msinformuser/');

if ($modx->error->hasError() || !($msInformUser instanceof msInformUser)) {
    die('Error');
}

$response = $msInformUser->handleRequest($action, $data);

if (is_array($response)) {
    $response = json_encode($response);
}

@session_write_close();
exit($response);
