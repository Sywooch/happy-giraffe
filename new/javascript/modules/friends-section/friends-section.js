define(['jquery', 'knockout', 'text!friends-section/friends-section.html', 'models/Friend', 'ko_library'], function FriendsSectionHandler ($, ko, template, Friend) {
    function FriendsSection(params) {
        this.userId = params.userId;
        this.userLimit = 12;
        this.friends = ko.observableArray();
        this.friendsUrl = '/friends/';
        this.getFriends = function getFriends() {
            return Friend.getFriendsUsers(this.userId, this.userLimit, 40);
        };
        this.prepareFriends = function prepareFriends(friends) {
            if (friends.length > 0) {
                this.friends(friends);
            }
        };
        this.getFriends().then(this.prepareFriends.bind(this));
    }


    return {
        viewModel: FriendsSection,
        template: template
    };
});