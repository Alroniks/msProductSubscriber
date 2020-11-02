var addFields = {
    id: 'msinformuser-field',
    layout: 'anchor',
    width: '100%',
    items: [{
        xtype: 'msinformuser-item-field'
    }]
};
var addFields1 = {
    id: 'msinformuser-iu-control-date-field',
    layout: 'anchor',
    width: '100%',
    items: [{
        xtype: 'msinformuser-item-iu-control-date'
    }]
};

if (this.miniShop2 && this.miniShop2.config.show_extra) {
    Ext.ComponentMgr.onAvailable('minishop2-product-tabs', function() {
        this.on('beforerender', function() {
            var tabOptions = this.items.items[2].items.items[0].items.items[0];
            tabOptions.add(addFields);
        });
    });
    // if (MODx.config.msinformuser_date_control_show == 1) {
    //     Ext.ComponentMgr.onAvailable('minishop2-product-tabs', function () {
    //         this.on('beforerender', function () {
    //             var tabOptions = this.items.items[1].items.items[0].items.items[1];
    //             tabOptions.add(addFields1);
    //         });
    //     });
    // }
} else {
    Ext.ComponentMgr.onAvailable('modx-resource-main-right', function() {
        this.on('beforerender', function() {
            this.add(addFields);
        });
    });
    // if (MODx.config.msinformuser_date_control_show == 1) {
    //     Ext.ComponentMgr.onAvailable('modx-page-settings-right', function () {
    //         this.on('beforerender', function () {
    //             this.add(addFields1);
    //         });
    //     });
    // }
}

/**
 *
 * @param config
 * @constructor
 */
if (MODx.config.msinformuser_date_control_show == 1) {
    msInformUser.panel.FieldPayment = function(config) {
        config = config || {};
        var form = Ext.getCmp('modx-panel-resource').getForm();
        Ext.apply(config, {
            baseParams: {},
            // layout: 'anchor',
            items: [{
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'xdatetime',
                    fieldLabel: _('msinformuser_date'),
                    description: '<b>[[*iu_control_date]]</b><br />'+_('msinformuser_date_help'),
                    name: 'iu_control_date',
                    allowBlank: true,
                    dateFormat: MODx.config.manager_date_format,
                    timeFormat: MODx.config.manager_time_format,
                    startDay: parseInt(MODx.config.manager_week_start),
                    dateWidth: 120,
                    timeWidth: 120,
                    value: form.record.iu_control_date
                }]
            }]
        });
        msInformUser.panel.FieldPayment.superclass.constructor.call(this, config);
    };
    Ext.extend(msInformUser.panel.FieldPayment, MODx.Panel, {});
    Ext.reg('msinformuser-item-iu-control-date', msInformUser.panel.FieldPayment);
}

/**
 *
 * @param config
 * @constructor
 */
msInformUser.panel.FieldForm = function(config) {
    config = config || {};
    var form = Ext.getCmp('modx-panel-resource').getForm();
    Ext.apply(config, {
        baseParams: {},
        // layout: 'anchor',
        items: [{
            layout: 'form',
            labelAlign: 'top',
            items: [
                this.getCountField(form),
                this.getEmailField(form),
                this.getDateField(form)
            ]
        }]
    });
    msInformUser.panel.FieldForm.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.panel.FieldForm, MODx.Panel, {

    getDateField: function(form) {
        if (MODx.config.msinformuser_date_control_show == 1) {
            return {
                xtype: 'xdatetime',
                fieldLabel: _('msinformuser_date'),
                description: '<b>[[*iu_control_date]]</b><br />'+_('msinformuser_date_help'),
                name: 'iu_control_date',
                allowBlank: true,
                dateFormat: MODx.config.manager_date_format,
                timeFormat: MODx.config.manager_time_format,
                startDay: parseInt(MODx.config.manager_week_start),
                dateWidth: 120,
                timeWidth: 120,
                value: form.record.iu_control_date
            }
        } else {
            return {};
        }
    },

    getEmailField: function(form) {
        if (MODx.config.msinformuser_send_show == 1) {
            return {
                title: _('msinformuser_open_send'),
                xtype: 'fieldset',
                cls: 'x-fieldset-checkbox-toggle',
                checkboxToggle: true,
                collapsed: Ext.state.Manager.get('msinformuser-collapsed') != true ? false : true,
                forceLayout: true,
                labelAlign: 'top',
                listeners: {
                    'expand': {
                        fn: function (p) {
                            Ext.state.Manager.set('msinformuser-collapsed', false);
                        }, scope: this
                    },
                    'collapse': {
                        fn: function (p) {
                            Ext.state.Manager.set('msinformuser-collapsed', true);
                        }, scope: this
                    }
                },
                items: [{
                    xtype: 'textfield',
                    anchor: '100%',
                    vtype: 'email',
                    id: 'msinformuser-input-email',
                    // description: _('msinformuser_input-email_desc'),
                    name: 'im_email',
                    emptyText: 'user@domain.com',
                    value: form.record.iu_email
                },{
                    tbar: this.getButton()
                }]
            }
        } else {
            return {};
        }
    },

    getCountField: function(form) {
        if (MODx.config.msinformuser_count_show == 1) {
            return {
                xtype: 'numberfield',
                fieldLabel: _('msinformuser_count'),
                description: '<b>[[*iu_count]]</b><br />'+_('msinformuser_count_desc'),
                name: 'iu_count',
                id: 'msinformuser_count',
                anchor: '100%',
                value: form.record.iu_count
            };
        } else {
            return {};
        }
    },

    getButton: function() {
        return [ '->', {
            xtype: 'button',
            text: '<i class="icon icon-send"></i>&nbsp;&nbsp;' + _('msinformuser_send'),
            handler: this.send
        }]
    },

    send: function() {
        var email = Ext.getCmp('msinformuser-input-email').getValue();
        var form = Ext.getCmp('modx-panel-resource').getForm();

        // Валидация Email
        var ereg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        var result = ereg.test(email);

        if (MODx.isEmpty(email)) {
            return MODx.msg.alert(_('error'), _('msinformuser_err_not_email'));
        } else if (!result) {
            return MODx.msg.alert(_('error'), _('msinformuser_err_email_validate'));
        }
        // Отправить
        if (email) {
            MODx.msg.confirm({
                title: _('msinformuser_open_send'),
                text: _('msinformuser_send_question') + '<strong> ' + email + '</strong>',
                url: msInformUser.config.connector_url,
                params: {
                    action: 'mgr/fieldresource/send',
                    email: email,
                    id: form.record.id

                },
                listeners: {
                    success: {
                        fn: function (msg) {
                            MODx.msg.alert(_('success'), msg.message);
                        }
                    },
                    error: {
                        fn: function (msg) {
                            MODx.msg.alert(_('error'), msg);
                        }
                    }
                }
            });
        }
    }
});
Ext.reg('msinformuser-item-field', msInformUser.panel.FieldForm);