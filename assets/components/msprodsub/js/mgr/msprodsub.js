let msProdSub = function (config) {
    config = config || {};
    msProdSub.superclass.constructor.call(this, config);
};
Ext.extend(msProdSub, Ext.Component, {
    page: {}, window: {}, grid: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('msprodsub', msProdSub);

msProdSub = new msProdSub();
