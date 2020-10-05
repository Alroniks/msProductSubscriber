msProdSub.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    msProdSub.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(msProdSub.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('msinformuser-combo-search', msProdSub.combo.Search);
Ext.reg('msinformuser-field-search', msProdSub.combo.Search);


msProdSub.combo.Chunk = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: msProdSub.config.connector_url,
        baseParams: {
            action: 'mgr/elements/chunk/getlist',
            mode: 'chunks'
        },
        name: 'chunk',
        hiddenName: config.name || 'chunk',
        displayField: 'name',
        valueField: 'id',
        editable: true,
        fields: ['id', 'name'],
        pageSize: 20,
        emptyText: _('msinformuser_select_chunk'),
        hideMode: 'offsets',
    });
    msProdSub.combo.Chunk.superclass.constructor.call(this, config);
};
Ext.extend(msProdSub.combo.Chunk, MODx.combo.ComboBox);
Ext.reg('msinformuser-combo-chunk', msProdSub.combo.Chunk);


msProdSub.combo.Groups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: msProdSub.config.connector_url,
        baseParams: {
            action: 'mgr/settings/mailing/group/getlist',
            combo: true
        },
        name: 'group',
        fields: ['id','name'],
        hiddenName: config.name || 'group',
        pageSize: 20,
        valueField: 'id',
        displayField: 'name',
        editable: true,
        hideMode: 'offsets'
    });
    msProdSub.combo.Groups.superclass.constructor.call(this,config);
};
Ext.extend(msProdSub.combo.Groups, MODx.combo.ComboBox);
Ext.reg('clientconfig-combo-groups', msProdSub.combo.Groups);



msProdSub.combo.Class = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 'msinformuser-combo-mailing-group-class',
            fields: ['class','display'],
            data: [
                ['modResource','modResource']
            ]
        }),
        mode: 'local',
        displayField: 'class',
        valueField: 'class'
    });
    msProdSub.combo.Class.superclass.constructor.call(this, config);
};
Ext.extend(msProdSub.combo.Class, MODx.combo.ComboBox);
Ext.reg('msinformuser-combo-mailing-group-class', msProdSub.combo.Class);
