msInformUser.panel.Admin = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('msinformuser') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            // border: true,
            hideMode: 'offsets',
            stateful: true,
            stateId: 'msinformuser-panel-admin',
            stateEvents: ['tabchange'],
            getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
            items: [{
                title: _('msinformuser_queue'),
                layout: 'anchor',
                items: [{
                    xtype: 'modx-tabs',
                    id: 'msinformuser-queue-tabs',
                    stateful: true,
                    stateId: 'msinformuser-queue-tabs',
                    stateEvents: ['tabchange'],
                    getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
                    items: [{
                        title: 'Отложенная рассылка',
                        layout: 'anchor',
                        items: [{
                            xtype: 'msinformuser-grid-delayed-mailing',
                            cls: 'main-wrapper'
                        }]
                    },{
                        title: 'Поступление',
                        layout: 'anchor',
                        items: [{
                            xtype: 'msinformuser-grid-receipt',
                            cls: 'main-wrapper'
                        }]
                    }]
                }]
            },{
                title: _('msinformuser_sent'),
                layout: 'anchor',
                items: [{
                    html: _('msinformuser_sent_msg'),
                    cls: 'panel-desc'
                },{
                    xtype: 'msinformuser-grid-sent',
                    cls: 'main-wrapper'
                }]
            }]
        }]
    });
    msInformUser.panel.Admin.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.panel.Admin, MODx.Panel);
Ext.reg('msinformuser-panel-admin', msInformUser.panel.Admin);
