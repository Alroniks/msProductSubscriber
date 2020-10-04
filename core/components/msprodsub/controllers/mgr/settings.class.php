<?php

/**
 * The home manager controller for msInformUser.
 *
 */
class msInformUserMgrSettingsManagerController extends modExtraManagerController
{
    /** @var msInformUser $msInformUser */
    public $msInformUser;


    /**
     *
     */
    public function initialize()
    {
        $this->msInformUser = $this->modx->getService('msInformUser', 'msInformUser', MODX_CORE_PATH . 'components/msinformuser/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['msinformuser:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('msinformuser_settings');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->msInformUser->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/msinformuser.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/settings/mailing.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/settings/mailinggroup.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/widgets/settings/settings.panel.js');
        $this->addJavascript($this->msInformUser->config['jsUrl'] . 'mgr/sections/settings/settings.js');

        $this->addHtml('<script type="text/javascript">
        msInformUser.config = ' . json_encode($this->msInformUser->config) . ';
        msInformUser.config.connector_url = "' . $this->msInformUser->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "msinformuser-page-settings"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="msinformuser-panel-settings-div"></div>';

        return '';
    }
}