define(['jquery', 'knockout', 'models/Model', 'models/User'], function FriendHandler($, ko, Model, User) {
    var Friend = {
        getFriendsUrl: '/api/friends/list/',
        getUserUrl: '/api/users/get/',
        getRelationshipStatusUrl: '/api/friends/relationshipStatus/',
        total: 0,
        getFriends: function getFriends(userId, limit) {
            return Model.get(this.getFriendsUrl, { userId: userId, limit: limit });
        },
        retrieveFriendsArray: function retrieveFriendsArray(data) {
            if (data.success === true) {
                this.total = data.data.total;
                return Model.get(this.getUserUrl, { pack: data.data.list, avatarSize: 40 });
            }
            return data;
        },
        getFriendsDfd: function parseFriendsArray(friendsUserData) {
            if (friendsUserData.success === true) {
                var parsedFriends =  friendsUserData.data.map(User.parsePack);
                return parsedFriends;
            }
            return friendsUserData;
        },
        getFriendsUsers: function getFriendsUsers(userId, limit, avatarSize) {
            var dfd = this.getFriends(userId, limit);
            return dfd
                .then(this.retrieveFriendsArray.bind(this))
                .then(this.getFriendsDfd.bind(this));

        },
        getRelationshipStatusParsed: function getRelationshipStatusParsed(data) {
            if (data.success === true) {
                this.hasIncomingRequest(data.data.hasIncomingRequest);
                this.hasOutgoingRequest(data.data.hasOutgoingRequest);
                this.isFriend(data.data.isFriend);
            }
        },
        getRelationshipStatus: function relationshipStatus(userId) {
            return Model.get(this.getRelationshipStatusUrl, { user1Id: userId, user2Id: this.id });
        },
        friendsInvite: function friendsInvite() {
            this.hasIncomingRequest(true);
            return $.post('/friendRequests/send/', { to_id : this.id });
        },
        friendsAccept: function friendsAccept() {
            this.isFriend(true);
            return $.post('/friends/requests/accept/', { fromId : this.id });
        },
        friendsDecline: function friendsDecline() {
            return $.post('/friends/requests/decline/', { fromId : this.id });
        },
        init: function initFriendOrNot(data) {
            this.id = data.id;
            this.isFriend = ko.observable(data.isFriend === undefined ? false : data.isFriend);
            this.hasIncomingRequest = ko.observable(data.hasIncomingRequest === undefined ? false : data.hasIncomingRequest);
            this.hasOutgoingRequest = ko.observable(data.hasOutgoingRequest === undefined ? false : data.hasOutgoingRequest);
            this.hasNoRelationship = ko.computed(function () {
                return !this.isFriend() && !this.hasIncomingRequest() && !this.hasOutgoingRequest();
            }, this);
        }
    };
    return Friend;
});