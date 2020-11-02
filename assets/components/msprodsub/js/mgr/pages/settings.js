msProdSub.page.Settings = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'msprodsub-panel-settings',
            renderTo: 'msprodsub-panel-settings'
        }]
    });
    msProdSub.page.Settings.superclass.constructor.call(this, config);
};
Ext.extend(msProdSub.page.Settings, MODx.Component);
Ext.reg('msprodsub-page-settings', msProdSub.page.Settings);
