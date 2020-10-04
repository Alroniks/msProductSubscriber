msInformUser.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'msinformuser-panel-admin',
            renderTo: 'msinformuser-panel-admin-div'
        }]
    });
    msInformUser.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.page.Home, MODx.Component);
Ext.reg('msinformuser-page-admin', msInformUser.page.Home);