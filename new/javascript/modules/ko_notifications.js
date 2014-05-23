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
        self.lastNotificationUpdate = false;
        self.fullyLoaded = false;
        self.loading = ko.observable(false);
        self.notifications = ko.observableArray([]);
        self.addNotifications = function(data) {
            self.notifications(self.notifications().concat(ko.utils.arrayMap(data, function(item) {
                if (!self.lastNotificationUpdate || self.lastNotificationUpdate > item.updated)
                    self.lastNotificationUpdate = item.updated;
                return new Notify(item);
            })));
        };
        self.addNotifications(data.list);
        self.tab = ko.observable(1 * data.read);
        /*self.tabs = [
            function(item) {
                return item.read == 0;
            },
            function(item) {
                return item.read == 1;
            },
        ];
        self.currentTab = ko.computed(function() {
            self.tab();
            return ko.utils.arrayFilter(self.notifications(), function(item) {
                return self.tabs[self.tab()](item);
            });
        });
        self.changeTab = function(newTab) {
            self.tab(newTab);
        };*/
        self.markAllAsReaded = function() {
            ko.utils.arrayForEach(self.notifications(), function(item) {
                item.setReaded();
            });
        };
        self.load = function() {
            if (!self.loading() && !self.fullyLoaded) {
                self.loading(true);
                $.get('/notifications/', {'lastNotificationUpdate': self.lastNotificationUpdate, read: self.tab()}, function(data) {
                    if (data.list.length < 20)
                        self.fullyLoaded = true;
                    self.addNotifications(data.list);
                    self.loading(false);
                }, 'json');
            }
        };
    }

    return ViewModel;
});