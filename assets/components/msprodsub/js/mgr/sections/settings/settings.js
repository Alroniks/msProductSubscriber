msInformUser.page.Settings = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'msinformuser-panel-settings',
            renderTo: 'msinformuser-panel-settings-div'
        }]
    });
    msInformUser.page.Settings.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.page.Settings, MODx.Component);
Ext.reg('msinformuser-page-settings', msInformUser.page.Settings);