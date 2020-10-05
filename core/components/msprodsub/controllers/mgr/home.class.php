<?php

/**
 * The home manager controller for msProdSub.
 */
class msProdSubMgrHomeManagerController extends modExtraManagerController
{
    public $msInformUser;

    public function initialize()
    {
        $this->msInformUser = $this->modx->getService('msInformUser', 'msInformUser', MODX_CORE_PATH . 'components/msinformuser/model/');

        parent::initialize();
    }

    public function getLanguageTopics(): array
    {
        return ['msprodsub:default'];
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('msprodsub');
    }

    public function loadCustomCssJs(): void
    {
        $this->addCss($this->msInformUser->config['cssUrl'] . 'mgr/main.css');

        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/msprodsub.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/administration/receipt.grid.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/administration/sent.grid.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/administration/delayedmailing.grid.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/administration/admin.panel.js');

        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/pages/home.js');

        $this->addHtml('<script type="text/javascript">
        msInformUser.config = ' . json_encode($this->msInformUser->config) . ';
        msInformUser.config.connector_url = "' . $this->msInformUser->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "msinformuser-page-admin"});});
        </script>');
    }

    public function getTemplateFile(): string
    {
        $this->content .= '<div id="msprodsub-panel-home"></div>';

        return parent::getTemplateFile();
    }
}
