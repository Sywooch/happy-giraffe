var LayoutViewModel = function(data) {
    var self = this;
    self.newNotificationsCount = ko.observable(data.newNotificationsCount);
    self.newMessagesCount = ko.observable(data.newMessagesCount);
    self.newFriendsCount = ko.observable(data.newFriendsCount);
}