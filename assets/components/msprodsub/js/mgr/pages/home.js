msProdSub.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'msprodsub-panel-home',
            renderTo: 'msprodsub-panel-home'
        }]
    });
    msProdSub.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(msProdSub.page.Home, MODx.Component);
Ext.reg('msprodsub-page-home', msProdSub.page.Home);
