var LayoutViewModel = function() {
    var self = this;
    self.newNotificationsCount = ko.observable(0);
    self.newMessagesCount = ko.observable(1);
    self.newFriendsCount = ko.observable(0);
}