msInformUser.panel.Settings = function (config) {
    config = config || {};
    Ext.apply(config, {
        cls: 'container',
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('msinformuser') + ' :: ' + _('msinformuser_settings') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            stateful: true,
            stateId: 'msinformuser-panel-settings',
            stateEvents: ['tabchange'],
            getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
            items: [{
                title: _('msinformuser_mailing'),
                layout: 'anchor',
                items: [{
                    html: _('msinformuser_mailing_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'msinformuser-grid-mailing',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('msinformuser_mailing_groups'),
                layout: 'anchor',
                items: [{
                    html: _('msinformuser_mailing_groups_msg'),
                    cls: 'panel-desc',
                },{
                    xtype: 'msinformuser-grid-mailing-group',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    msInformUser.panel.Settings.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.panel.Settings, MODx.Panel);
Ext.reg('msinformuser-panel-settings', msInformUser.panel.Settings);
