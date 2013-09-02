var LayoutViewModel = function(data) {
    var self = this;
    self.newNotificationsCount = ko.observable(data.newNotificationsCount);
    self.newMessagesCount = ko.observable(data.newMessagesCount);
    self.newFriendsCount = ko.observable(data.newFriendsCount);

    self.inc = function(observable) {
        observable(observable() + 1);
    }

    Comet.prototype.incNewFriendsCount = function(result, id) {
        self.inc(self.newFriendsCount());
    };

    comet.addEvent(1001, 'incNewFriendsCount');
}