<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var msInformUser $msInformUser */
$msInformUser = $modx->getService('msInformUser', 'msInformUser', MODX_CORE_PATH . 'components/msinformuser/model/');
$modx->lexicon->load('msinformuser:default');

// handle request
$corePath = $modx->getOption('msinformuser_core_path', null, $modx->getOption('core_path') . 'components/msinformuser/');
$path = $modx->getOption('processorsPath', $msInformUser->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);