msInformUser.grid.Mailing = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-grid-mailing';
    }
    Ext.applyIf(config, {
        url: msInformUser.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        // sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/settings/mailing/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateMailing(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'msinformuser-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    msInformUser.grid.Mailing.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(msInformUser.grid.Mailing, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = msInformUser.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    addQueueMailingGroup: function(btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var data = this.menu.record;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/addqueue',
                method: 'addQueue',
                data: Ext.util.JSON.encode(data)
            },
            listeners: {
                success: {
                    fn: function (response) {
                        MODx.msg.alert(_('success'), response.message);
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message.message);
                    }, scope: this
                },
            }
        });
    },

    createMailing: function (btn, e) {
        var groups = Ext.getCmp('msinformuser-grid-mailing-group');
        if (groups.store.data.items.length < 1) {
            MODx.msg.alert(
                _('msinformuser_create_groups'),
                _('msinformuser_create_groups_desc')
            );
            return;
        }

        var w = MODx.load({
            xtype: 'msinformuser-mailing-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    updateMailing: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'msinformuser-mailing-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeMailing: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('msinformuser_remove_selected')
                : _('msinformuser_remove'),
            text: ids.length > 1
                ? _('msinformuser_remove_selected_confirm')
                : _('msinformuser_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    disableMailing: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enableMailing: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    getFields: function () {
        return ['id', 'name', 'description', 'subject', 'sender', 'reply_to',
            'template', 'attachment', 'group', 'active', 'start_mailing', 'control_date_field',
            'send_email_field', 'actions'];
    },

    getColumns: function () {
        return [{
            header: 'Id',
            dataIndex: 'id',
            sortable: true,
            width: 50
        }, {
            header: _('msinformuser_name'),
            dataIndex: 'name',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_description'),
            dataIndex: 'description',
            sortable: false,
            width: 250,
        },{
            header: _('msinformuser_subject'),
            dataIndex: 'subject',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_sender'),
            dataIndex: 'sender',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_reply_to'),
            dataIndex: 'reply_to',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_template'),
            dataIndex: 'template',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_attachment'),
            dataIndex: 'attachment',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_active'),
            dataIndex: 'active',
            renderer: msInformUser.utils.renderBoolean,
            sortable: true,
            width: 100,
        }, {
            header: _('msinformuser_actions'),
            dataIndex: 'actions',
            renderer: msInformUser.utils.renderActions,
            sortable: false,
            width: 150,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('msinformuser_add'),
            handler: this.createMailing,
            scope: this
        }, '->', {
            xtype: 'msinformuser-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('msinformuser-grid-mailing', msInformUser.grid.Mailing);

/**
 * Windows
 *
 * @param config
 * @constructor
 */
msInformUser.window.CreateMailing = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-mailing-window-create';
    }
    Ext.applyIf(config, {
        title: _('msinformuser_create'),
        width: 550,
        autoHeight: true,
        url: msInformUser.config.connector_url,
        action: 'mgr/settings/mailing/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    msInformUser.window.CreateMailing.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.window.CreateMailing, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        },{
            xtype: 'textfield',
            fieldLabel: _('msinformuser_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('msinformuser_description'),
            name: 'description',
            id: config.id + '-description',
            height: 100,
            anchor: '99%'
        },{
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('msinformuser_subject'),
                    name: 'subject',
                    id: config.id + '-subject',
                    anchor: '99%',
                    allowBlank: false
                },{
                    xtype: 'textfield',
                    fieldLabel: _('msinformuser_reply_to'),
                    name: 'reply_to',
                    id: config.id + '-reply_to',
                    anchor: '99%'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('msinformuser_sender'),
                    name: 'sender',
                    id: config.id + '-sender',
                    anchor: '99%',
                    emptyText: 'noreply@domain.com',
                    allowBlank: false
                },{
                    xtype: 'msinformuser-combo-chunk',
                    fieldLabel: _('msinformuser_template'),
                    name: 'template',
                    id: config.id + '-template',
                    anchor: '99%',
                    allowBlank: false
                }]
            }]
        },{
            xtype: 'modx-combo-browser',
            fieldLabel: _('msinformuser_attachments'),
            name: 'attachment',
            id: config.id +'-attachment',
            anchor: '99%'
        },
            this.getCustomFields(config),
        {
            xtype: 'xcheckbox',
            boxLabel: _('msinformuser_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    getCustomFields: function(config) {
        if (config.record && config.record.object.id > 2) {
            return {
                layout: 'column',
                items: [{
                    columnWidth: .5,
                    layout: 'form',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('msinformuser_mailing_start'),
                        description: _('msinformuser_mailing_start_desc'),
                        name: 'start_mailing',
                        id: config.id + '-start_mailing',
                        anchor: '99%',
                        allowBlank: false
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('msinformuser_mailing_send_email_field'),
                        description: _('msinformuser_mailing_send_email_field_desc'),
                        name: 'send_email_field',
                        id: config.id +'-send_email_field',
                        anchor: '99%'
                    }]
                },{
                    columnWidth: .5,
                    layout: 'form',
                    items: [{
                        xtype: 'displayfield',
                        fieldLabel: _('msinformuser_mailing_control_date_field'),
                        description: _('msinformuser_mailing_control_date_field_desc'),
                        name: 'control_date_field',
                        id: config.id + '-control_date_field',
                        anchor: '99%'
                    },{
                        xtype: 'clientconfig-combo-groups',
                        fieldLabel: _('msinformuser_mailing_group'),
                        name: 'group',
                        id: config.id + '-group',
                        anchor: '99%',
                        allowBlank: false
                    }]
                }/*,{
                    columnWidth: 1,
                    layout: 'form',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('msinformuser_mailing_parents_res'),
                        description: _('msinformuser_mailing_parents_res_desc'),
                        name: 'parents_res',
                        id: config.id + '-parents_res',
                        allowBlank: false
                    }]
                }*/]
            }
        } else {
            return {};
        }
    }
});
Ext.reg('msinformuser-mailing-window-create', msInformUser.window.CreateMailing);

msInformUser.window.UpdateMailing = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-mailing-window-update';
    }
    Ext.applyIf(config, {
        title: _('msinformuser_update'),
        width: 550,
        autoHeight: true,
        url: msInformUser.config.connector_url,
        action: 'mgr/settings/mailing/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    msInformUser.window.UpdateMailing.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.window.UpdateMailing, msInformUser.window.CreateMailing);
Ext.reg('msinformuser-mailing-window-update', msInformUser.window.UpdateMailing);

