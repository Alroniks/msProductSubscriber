msInformUser.grid.Receipt = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-grid-receipt';
    }
    Ext.applyIf(config, {
        url: msInformUser.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        // sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/administration/receipt/getlist',
            mailing_index: 2
        },
        // listeners: {
        //     rowDblClick: function (grid, rowIndex, e) {
        //         var row = grid.store.getAt(rowIndex);
        //         this.updateItem(grid, e, row);
        //     }
        // },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    msInformUser.grid.Receipt.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(msInformUser.grid.Receipt, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = msInformUser.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    removeReceipt: function () {
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
                action: 'mgr/administration/receipt/remove',
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
        return ['id', 'title', 'name', 'res_id', 'mailing_index', 'count', 'user_id', 'email',
            'createdon', 'updatedon', 'senddate', 'status', 'actions'];
    },

    getColumns: function () {
        return [{
            dataIndex: 'id',
            hidden: true
        }, {
            dataIndex: 'mailing_index',
            hidden: true
        },{
            header: _('msinformuser_name'),
            dataIndex: 'title',
            sortable: true,
            renderer: function(val, cell, row) {
                return msInformUser.utils.pagetitleLink(val, row.data['res_id'], true);
            },
            width: 200
        }, {
            header: _('msinformuser_mailing'),
            dataIndex: 'name',
            sortable: true,
            width: 200
        },{
            header: _('msinformuser_count'),
            dataIndex: 'count',
            sortable: true,
            width: 50
        },{
            header: _('user'),
            dataIndex: 'user_id',
            sortable: true,
            width: 70
        },{
            header: _('email'),
            dataIndex: 'email',
            sortable: true,
            width: 150,
        },{
            header: _('createdon'),
            dataIndex: 'createdon',
            sortable: true,
            width: 150,
        },{
            header: _('updated'),
            dataIndex: 'updatedon',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_senddate'),
            dataIndex: 'senddate',
            sortable: true,
            width: 150,
        },{
            header: _('msinformuser_status'),
            dataIndex: 'status',
            sortable: true,
            width: 100,
        },{
            header: _('msinformuser_actions'),
            dataIndex: 'actions',
            renderer: msInformUser.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [ '->', {
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
    }
});
Ext.reg('msinformuser-grid-receipt', msInformUser.grid.Receipt);


msInformUser.window.UpdateReceipt = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-receipt-window-update';
    }
    Ext.applyIf(config, {
        title: _('msinformuser_update'),
        width: 550,
        autoHeight: true,
        url: msInformUser.config.connector_url,
        action: 'mgr/administration/receipt/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    msInformUser.window.UpdateReceipt.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.window.UpdateReceipt, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        },{
            xtype: 'displayfield',
            fieldLabel: _('msinformuser_name'),
            name: 'title',
            id: config.id + '-title',
            anchor: '99%',
        },/*{
            xtype: 'displayfield',
            fieldLabel: _('msinformuser_mailing'),
            name: 'name',
            id: config.id + '-mailing_index',
            anchor: '99%',
        },*/{
            xtype: 'textfield',
            fieldLabel: _('email'),
            name: 'email',
            id: config.id +'-email',
            anchor: '99%'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('msinformuser-receipt-window-update', msInformUser.window.UpdateReceipt);