define('friend', ["knockout", "giraffe-extend", "knockout-amd-helpers"], function(ko, extend) {
    function FriendUser(data) {
        var self = this;
        self.FRIENDS_STATE_FRIENDS = 0;
        self.FRIENDS_STATE_OUTGOING = 1;
        self.FRIENDS_STATE_INCOMING = 2;
        self.FRIENDS_STATE_NOTHING = 3;
        self.friendsState = ko.computed(function() {
            if (data.isFriend())
                return self.FRIENDS_STATE_FRIENDS;
            if (data.hasIncomingRequest())
                return self.FRIENDS_STATE_INCOMING;
            if (data.hasOutgoingRequest())
                return self.FRIENDS_STATE_OUTGOING;
            return self.FRIENDS_STATE_NOTHING;
        });
        data.id;
        self.friendsInvite = function() {
            $.post('/friendRequests/send/', { to_id : data.id });
        };
        self.friendsAccept = function() {
            $.post('/friends/requests/accept/', { fromId : data.id });
        };
        self.friendsDecline = function() {
            $.post('/friends/requests/decline/', { fromId : data.id });
        };
    };
    
    return function(data) {
        extend(data, new FriendUser(data));
        return data;
    };
})