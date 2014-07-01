define('ko_notifications', ['knockout', 'comet', 'ko_library', 'common'], function(ko) {
    var types = {
        0: 'comment',
        1: 'reply',
        2: 'discuss',
        5: 'like',
        6: 'favorite'
    };
    
    function AccumulatingRequest(timeout, url, data, callback) {
        var self = this;
        var events = ko.observableArray([]);
        self.url = url;
        self.data = data ? data : {};
        self.callback = callback ? callback : function() { };
        self.send = function(data) {
            events.push(data);
        };
        ko.computed(function() {
            if(events().length > 0) {
                data = ko.utils.extend({}, self.data);
                data.events = events();
                $.post(self.url, data, self.callback, 'json');
                events([]);
            }
        }).extend({ throttle: timeout });
    }
    
    function User(id, avatar) {
        var self = this;
        self.id = id;
        self.avatar = avatar;
        self.url = '/user/' + id + '/';
    }

    Notify.prototype = {
        objects: {},
        binded: false,
        request: new AccumulatingRequest(500, '/notifications/read/'),
        addObject: function(obj) {
            this.objects[obj.id] = obj;
        },
        bindEvents: function() {
            var self = this;
            if (!Notify.prototype.binded) {
                Notify.prototype.binded = true;
                Comet.prototype.notificationReaded = function(result, id) {
                    var obj = self.objects[result.notification.id] ? self.objects[result.notification.id] : false;
                    if(obj) {
                        obj.readed(true);
                    }
                    self.viewModel.unreadCount(Math.max(0, self.viewModel.unreadCount() - 1));
                }
                comet.addEvent(5002, 'notificationReaded');
            }
        }
    };

    function Notify(data, viewModel) {
        ko.utils.extend(this, data);
        var self = this;
        self.viewModel = viewModel;
        self.count = ko.observable(viewModel.read ? self.readCount : self.unreadCount);
        self.type = types[self.type];
        self.readed = ko.observable(false);
        
        self.unreadAvatars = [];
        for(var userId in data.unreadAvatars) {
            self.unreadAvatars.push(new User(userId, data.unreadAvatars[userId]));
        }
        self.unreadAvatars = ko.observableArray(self.unreadAvatars);
        self.readAvatars = [];
        for(var userId in data.readAvatars) {
            self.readAvatars.push(new User(userId, data.readAvatars[userId]));
        }
        self.readAvatars = ko.observableArray(self.readAvatars);
        
        self.setReaded = function() {
            self.request.send(self.id);
        };
        self.avatars = ko.computed(function() {
            return self.viewModel.tab() == 0 ? self.unreadAvatars() : self.readAvatars();
        });

        self.addObject(self);
        self.bindEvents();
    }
    function ViewModel(data) {
        var self = this;
        self.lastNotificationUpdate = false;
        self.fullyLoaded = false;
        self.loading = ko.observable(false);
        self.unreadCount = ko.observable(data.unreadCount);
        self.notifications = ko.observableArray([]);
        self.tab = ko.observable(1 * data.read);
        self.addNotifications = function(data) {
            self.notifications(self.notifications().concat(ko.utils.arrayMap(data, function(item) {
                if (!self.lastNotificationUpdate || self.lastNotificationUpdate > item.dtimeUpdate)
                    self.lastNotificationUpdate = item.dtimeUpdate;
                return new Notify(item, self);
            })));
        };
        self.addNotifications(data.list);
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