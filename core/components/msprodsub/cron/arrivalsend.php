<?php
#!/usr/bin/php

/** @var modX $modx */
/** @var msInformUser $msInformUser */

define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

$msInformUser = $modx->getService('msinformuser', 'msInformUser', $modx->getOption('msinformuser_core_path', null,
        $modx->getOption('core_path') . 'components/msinformuser/') . 'model/msinformuser/');


if ($msInformUser->loadClasses()) {
    $msInformUser->stockOut->get();
} else {
    $modx->log(modX::LOG_LEVEL_ERROR, '[msInformUser] No class handler');
}

exit();