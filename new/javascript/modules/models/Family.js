define(['knockout', 'models/Model', 'models/User', 'user-config'], function FamilyModel(ko, Model, User, userConfig) {
    var Family = {
        base: '/api/family',
        userId: User.userId,
        getUrl: '/api/family/get/',
        needFillUrl: '/api/family/needFill/',
        updateUrl: '/api/family/update/',
        createMember: '/api/family/createMember/',
        updateMember: '/api/family/updateMember/',
        removeMember: '/api/family/removeMember/',
        restoreMember: '/api/family/restoreMember/',
        get: function getFamily(public) {
            return Model.get(this.getUrl, {userId: this.userId, });
        }
    };

    return Family;
});