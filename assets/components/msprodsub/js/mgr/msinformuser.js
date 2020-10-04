var msInformUser = function (config) {
    config = config || {};
    msInformUser.superclass.constructor.call(this, config);
};
Ext.extend(msInformUser, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('msinformuser', msInformUser);

msInformUser = new msInformUser();