define('ko_notifications', ['knockout', 'comet', 'ko_library', 'common'], function(ko, comet) {
    var types = {
        0: 'comment',
        1: 'reply',
        2: 'discuss',
        5: 'like',
        6: 'favorite',
        7: 'post',
    };
    
    function Notify(data) {
        ko.utils.extend(this, data);
        var self = this;
        self.count = ko.observable(self.count);
        self.visibleCount = ko.observable(self.visibleCount);
        self.type = types[self.type];
        self.readed = ko.observable(false);
        self.setReaded = function() {
            self.readed(true);
        };
    }
    function ViewModel(data) {
        var self = this;
        self.notifications = ko.observableArray(ko.utils.arrayMap(data.list, function(item) {
            return new Notify(item);
        }));
        self.markAllAsReaded = function() {
            ko.utils.arrayForEach(self.notifications(), function(item) {
                item.setReaded();
            });
        };
    }
    
    return ViewModel;
});