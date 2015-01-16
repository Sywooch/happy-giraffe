define(['knockout', 'models/Model', 'models/User'], function ClubHandler(ko, Model) {
    var Club = {
        getClubsUrl: '/api/community/getUserSubscriptions/',
        getClubs: function getClubs(userId) {
            return Model.get(this.getClubsUrl, { userId: userId });
        },
        init: function init(object) {
            this.id = object.id;
            this.sectionId = object.sectionId;
            this.url = object.url;
        }
    };
    return Club;
});