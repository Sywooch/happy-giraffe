define(['knockout', 'models/Model', 'models/User', 'user-config'], function FamilyModel(ko, Model, User, userConfig) {
    var Family = {
        id: ko.observable(null),
        description: ko.observable(null),
        base: '/api/family',
        userId: User.userId,
        getUrl: '/api/family/get/',
        createUrl: '/api/family/create/',
        needFillUrl: '/api/family/needFill/',
        updateUrl: '/api/family/update/',
        get: function getFamily(public) {
            return Model.get(this.getUrl, {userId: this.userId});
        },
        create: function createFamily() {
            return Model.get(this.createUrl);
        },
        init: function initFamily(data) {
            this.id(data.id);
            this.description(data.description);
        }
    };

    return Family;
});