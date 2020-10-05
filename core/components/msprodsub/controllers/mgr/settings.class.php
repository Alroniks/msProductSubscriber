<?php

declare(strict_types=1);

class msProdSubMgrSettingsManagerController extends modExtraManagerController
{
    public $service;

    public function initialize(): void
    {
        $this->service = $this->modx->getService(
            'msInformUser',
            'msInformUser',
            MODX_CORE_PATH . 'components/msprodsub/model/'
        );
    }

    public function getLanguageTopics(): array
    {
        return ['msprodsub:default'];
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('msprodsub_settings');
    }

    public function loadCustomCssJs(): void
    {
        $this->addCss($this->service->config['cssUrl'] . 'mgr/main.css');

        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/msinformuser.js');
        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/widgets/settings/mailing.js');
        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/widgets/settings/mailinggroup.js');
        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/widgets/settings/settings.panel.js');

        $this->addJavascript($this->service->config['jsUrl'] . 'mgr/pages/settings.js');

        $this->addHtml('<script type="text/javascript">
        msInformUser.config = ' . json_encode($this->msInformUser->config, JSON_THROW_ON_ERROR) . ';
        msInformUser.config.connector_url = "' . $this->msInformUser->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "msinformuser-page-settings"});});
        </script>');
    }

    public function getTemplateFile(): string
    {
        $this->content .= '<div id="msprodsub-panel-settings"></div>';

        return parent::getTemplateFile();
    }
}
