var LayoutViewModel = function(data) {
    var self = this;
    self.newNotificationsCount = ko.observable(data.newNotificationsCount);
    self.newMessagesCount = ko.observable(data.newMessagesCount);
    self.newFriendsCount = ko.observable(data.newFriendsCount);
    self.newPostsCount = ko.observable(data.newPostsCount);
    self.newScoreCount = ko.observable(data.newScoreCount);
    self.activeModule = ko.observable(data.activeModule);

    $(function() {
        Comet.prototype.incNewFriendsCount = function(result, id) {
            self.newFriendsCount(self.newFriendsCount() + 1);
        };

        Comet.prototype.incNewMessagesCount = function(result, id) {
            self.newMessagesCount(self.newMessagesCount() + 1);
        };

        Comet.prototype.incNewNotificationsCount = function(result, id) {
            self.incNewNotificationsCount(self.incNewNotificationsCount() + 1);
        };

        Comet.prototype.incScoresCount = function(result, id) {
            self.newScoreCount(self.newScoreCount() + 1);
        };

        comet.addEvent(1000, 'incNewNotificationsCount');
        comet.addEvent(1001, 'incNewFriendsCount');
        comet.addEvent(2000, 'incNewMessagesCount');
        comet.addEvent(23, 'incScoresCount');
    });

}