<?php

/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnMODXInit':
        /** @var msInformUser $msInformUser */
        if (!$msInformUser = $modx->getService(
            'msInformUser', 'msInformUser', MODX_CORE_PATH . 'components/msinformuser/model/'
        )) {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->event->name . ' '
                . $modx->lexicon('msinformuser_err_not_class') . ' msInformUser');
            return;
        }
        $msInformUser->initialize();
        break;

    case 'OnDocFormPrerender':
        /** @var msInformUser $msInformUser */
        $msInformUser = $modx->getService('msInformUser');
        /** @var msInformUserMailing $msInformUserMailing */
        if ($modx->getCount('msInformUserMailing', ['index' => 1, 'active' => 1])) {
            $patch = MODX_ASSETS_URL . 'components/msinformuser/js/mgr/';
            $modx->controller->addLexiconTopic('msinformuser:default');
            $modx->regClientStartupScript($patch . 'sections/resource/field.resource.js');
            $modx->controller->addJavascript($patch . 'msinformuser.js');
            $modx->controller->addHtml('<script type="text/javascript">
                msInformUser.config = ' . json_encode($msInformUser->config) . ';
                msInformUser.config.connector_url = "' . $msInformUser->config['connectorUrl'] . '";
            </script>
            ');
        }
        break;
}
