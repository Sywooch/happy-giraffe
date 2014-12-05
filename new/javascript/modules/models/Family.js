define(['knockout', 'models/Model', 'models/User', 'user-config', 'models/FamilyMember', 'moment', 'photo/PhotoCollection'], function FamilyModel(ko, Model, User, userConfig, FamilyMember, moment, PhotoCollection) {
    var Family = {
        id: ko.observable(null),
        description: ko.observable(null),
        base: '/api/family',
        userId: parseInt(User.userId),
        getUrl: '/api/family/get/',
        createUrl: '/api/family/create/',
        needFillUrl: '/api/family/needFill/',
        updateUrl: '/api/family/update/',
        members: ko.observableArray(),
        photo: ko.observable(null),
        photoCollection: ko.observable(),
        get: function getFamily(public) {
            return Model.get(this.getUrl, {userId: this.userId});
        },
        create: function createFamily() {
            return Model.get(this.createUrl);
        },
        update: function updateFamily(attribObj) {
            return Model.get(this.updateUrl, {attributes: attribObj, id: this.id()});
        },
        photoAttaching: function photoAttaching (value) {
            console.log(value);
        },
        init: function initFamily(data) {
            this.id(data.id);
            this.description = Model.createStdProperty(data.description || null, 'description');
            this.description.editing(false);
            this.photoCollection(new PhotoCollection(data.photoCollection));
            this.photo.subscribe(this.photoAttaching, this);
            if (data.members !== undefined) {
                if (data.members.length > 0) {
                    for (var i=0; i < data.members.length; i++) {
                        var familyMember = Object.create(FamilyMember);
                        this.members.push(familyMember.init(data.members[i]));
                    }
                }
            }
        }
    };

    return Family;
});