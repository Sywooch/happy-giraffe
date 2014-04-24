define('ko_notifications', ['knockout', 'comet'], function(ko, comet) {
    function ViewModel(data) {
        var self = this;
        self.notifications = ko.observableArray(data.notifications);
    }
    
    return ViewModel;
});