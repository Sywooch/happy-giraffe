define(['knockout', 'models/Model', 'models/User'], function FriendHandler(ko, Model, User) {
    var Friend = {
        getFriendsUrl: '/api/friends/list/',
        getUserUrl: '/api/users/get/',
        getFriends: function getFriends(userId, limit) {
            return Model.get(this.getFriendsUrl, { userId: userId, limit: limit });
        },
        retrieveFriendsArray: function retrieveFriendsArray(data) {
            if (data.success === true) {
                return Model.get(this.getUserUrl, { pack: data.data, avatarSize: 40 });
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

        }
    };

    return Friend;
});