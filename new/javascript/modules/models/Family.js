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
        forbiddenArray: ko.observableArray(),
        get: function getFamily(public) {
            return Model.get(this.getUrl, {userId: this.userId});
        },
        create: function createFamily() {
            return Model.get(this.createUrl);
        },
        update: function updateFamily(attribObj) {
            return Model.get(this.updateUrl, {attributes: attribObj, id: this.id()});
        },
        photoAttaching: function photoAttaching () {
            if (this.photoCollection().attachesCount() > 0) {
               return this.photoCollection().cover();
            }
            return null;
        },
        removeFamilyPhoto: function removeFamilyPhoto() {
            this.photo().remove();
            this.photo(null);
        },
        init: function initFamily(data) {
            this.id(data.id);
            this.description = Model.createStdProperty(data.description || null, 'description');
            this.description.editing(false);
            this.photoCollection(new PhotoCollection(data.photoCollection));
            this.photo(this.photoAttaching());
            if (data.members !== undefined) {
                if (data.members.length > 0) {
                    for (var i=0; i < data.members.length; i++) {
                        if (parseInt(data.members[i].userId) !== this.userId) {
                            var familyMember = Object.create(FamilyMember);
                            this.forbiddenArray = FamilyMember.forbiddenFilterHandler(data.members[i], this.forbiddenArray);
                            this.members.push(familyMember.init(data.members[i]));
                        }
                    }
                }
            }
        }
    };

    return Family;
});