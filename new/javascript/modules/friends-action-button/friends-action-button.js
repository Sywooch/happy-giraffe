define(['../knockout', 'models/Friend', 'models/User', 'text!friends-action-button/friends-action-button.html'], function FriendsActionButtonHandler(ko, Friend, User, template) {
    function FriendsActionButton(params) {
        var dfd;
        this.userId = User.userId;
        this.friendId = params.friendId;
        this.friend = Object.create(Friend);
        this.friend.init({ id: this.friendId });
        this.loaded = ko.observable(false);
        this.endLoading = function endLoading() {
            this.loaded(true);
        };
        if (this.userId !== undefined || this.userId !== this.friendId ) {
            dfd = this.friend.getRelationshipStatus(this.userId);
            dfd.then(this.friend.getRelationshipStatusParsed.bind(this.friend));
            dfd.done(this.endLoading.bind(this));
        }
    }
    return {
        viewModel: FriendsActionButton,
        template: template
    };
})