msInformUser.grid.DelayedMailing = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'msinformuser-grid-delayed-mailing';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/administration/receipt/getlist',
            // status:
        },
    });
    msInformUser.grid.DelayedMailing.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser.grid.DelayedMailing, msInformUser.grid.Receipt, {

    getFields: function () {
        return ['id', 'title', 'name', 'res_id', 'mailing_index', 'user_id', 'email',
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
});
Ext.reg('msinformuser-grid-delayed-mailing', msInformUser.grid.DelayedMailing);