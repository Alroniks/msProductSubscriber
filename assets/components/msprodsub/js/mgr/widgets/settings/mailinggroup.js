msInformUser.grid.MailingGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-grid-mailing-group';
    }
    Ext.applyIf(config, {
        url: msInformUser.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        baseParams: {
            action: 'mgr/settings/mailing/group/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateMailingGroup(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            // getRowClass: function (rec) {
            //     return !rec.data.active
            //         ? 'msinformuser-grid-row-disabled'
            //         : '';
            // }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    msInformUser.grid.MailingGroup.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    // this.store.on('load', function () {
    //     if (this._getSelectedIds().length) {
    //         this.getSelectionModel().clearSelections();
    //     }
    // }, this);
};
Ext.extend(msInformUser.grid.MailingGroup, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = msInformUser.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createMailingGroup: function (btn, e) {
        var w = MODx.load({
            xtype: 'msinformuser-mailing-group-window-create',
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

    updateMailingGroup: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/mailing/group/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'msinformuser-mailing-group-window-update',
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

    removeMailingGroup: function () {
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
                action: 'mgr/settings/mailing/group/remove',
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

    getFields: function () {
        return ['id', 'name', 'description', 'class', 'actions'];
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
            header: _('msinformuser_class'),
            dataIndex: 'class',
            sortable: false,
            width: 250,
        },{
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
            handler: this.createMailingGroup,
            scope: this
        }/*, '->', {
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
        }*/];
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
    }
});
Ext.reg('msinformuser-grid-mailing-group', msInformUser.grid.MailingGroup);

/**
 * Windows
 *
 * @param config
 * @constructor
 */
msInformUser.window.CreateMailingGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-mailing-group-window-create';
    }
    Ext.applyIf(config, {
        title: _('msinformuser_create'),
        width: 550,
        autoHeight: true,
        url: msInformUser.config.connector_url,
        action: 'mgr/settings/mailing/group/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    msInformUser.window.CreateMailingGroup.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.window.CreateMailingGroup, MODx.Window, {

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
            // xtype: 'textfield',
            xtype: 'msinformuser-combo-mailing-group-class',
            fieldLabel: _('msinformuser_class'),
            name: 'class',
            id: config.id + '-class',
            anchor: '99%',
            allowBlank: false,
        }];
    }
});
Ext.reg('msinformuser-mailing-group-window-create', msInformUser.window.CreateMailingGroup);

msInformUser.window.UpdateMailingGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-mailing-group-window-update';
    }
    Ext.applyIf(config, {
        title: _('msinformuser_update'),
        width: 550,
        autoHeight: true,
        url: msInformUser.config.connector_url,
        action: 'mgr/settings/mailing/group/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    msInformUser.window.UpdateMailing.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.window.UpdateMailingGroup, msInformUser.window.CreateMailingGroup);
Ext.reg('msinformuser-mailing-group-window-update', msInformUser.window.UpdateMailingGroup);