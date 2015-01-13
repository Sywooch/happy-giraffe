define(['jquery', 'knockout', 'text!friends-section/friends-section.html', 'models/Model', 'models/Friend', 'ko_library'], function FriendsSectionHandler ($, ko, template, Model, Friend) {
    function FriendsSection(params) {
        this.userId = params.userId;
        this.userLimit = 12;
        this.friend = Object.create(Friend);
        this.friends = ko.observableArray();
        this.friendsUrl = '/user/' +  this.userId + '/friends/';
        this.loaded = ko.observable(false);
        this.rightsForManipulation = Model.checkRights(this.userId);
        this.getFriends = function getFriends() {
            return this.friend.getFriendsUsers(this.userId, this.userLimit, 40);
        };
        this.prepareFriends = function prepareFriends(friends) {
            if (friends.length > 0) {
                this.friends(friends);
            }
            this.loaded(true);
        };
        this.getFriends().then(this.prepareFriends.bind(this));
    }


    return {
        viewModel: FriendsSection,
        template: template
    };
});