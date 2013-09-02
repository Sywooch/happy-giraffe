var LayoutViewModel = function(data) {
    var self = this;
    self.newNotificationsCount = ko.observable(data.newNotificationsCount);
    self.newMessagesCount = ko.observable(data.newMessagesCount);
    self.newFriendsCount = ko.observable(data.newFriendsCount);

    $(function() {
        Comet.prototype.incNewFriendsCount = function(result, id) {
            self.newFriendsCount(self.newFriendsCount() + 1);
        };

        comet.addEvent(1001, 'incNewFriendsCount');
    });

}