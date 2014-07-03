define('ko_notifications', ['knockout', 'comet', 'ko_library', 'common', 'happyDebug'], function(ko) {
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
        self.callback = callback ? callback : function() {
        };
        self.send = function(data) {
            events.push(data);
        };
        ko.computed(function() {
            if (events().length > 0) {
                data = ko.utils.extend({}, self.data);
                data.events = events();
                $.post(self.url, data, self.callback, 'json');
                events([]);
            }
        }).extend({throttle: timeout});
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

                // Сигнал прочитан, уменьшим счётчики
                Comet.prototype.notificationUpdate = function(result, id) {
                    self.viewModel.unreadCount(Math.max(0, self.viewModel.unreadCount() - 1));
                }
                comet.addEvent(5002, 'notificationReaded');

                // Новый сигнал
                Comet.prototype.notificationAdded = function(result, id) {
                    happyDebug.log('ko_notifications.ViewModel.addNotification', 'log', 'Добавлен новый сигнал', self.viewModel.addNotification(result.notification));
                    self.viewModel.unreadCount(self.viewModel.unreadCount() + 1);
                }
                comet.addEvent(5001, 'notificationAdded');

                // Обновление сигнала, в т.ч. может стать прочитанным, или может обновиться сигнал из архива, и стать прочитанным
                Comet.prototype.notificationUpdated = function(result, id) {
                    var obj = self.objects[result.notification.id] ? self.objects[result.notification.id] : false;
                    if (obj) {
                        // обновление сигнала из списка
                        obj.update(result.notification);
                        happyDebug.log('ko_notifications.ViewModel.updateNotification', 'log', 'Обновлен сигнал из списка', obj);
                    } else if (((result.notification.unreadCount > 0) && self.tab() == 0) || ((result.notification.readCount > 0) && self.tab() == 1)) {
                        // надо добавить в список
                        happyDebug.log('ko_notifications.ViewModel.addNotification', 'log', 'Добавлен новый сигнал', self.viewModel.addNotification(result.notification));
                    } // иначе нас данный сигнал не интересует
                }
                comet.addEvent(5003, 'notificationUpdated');
            }
        }
    };

    function Notify(data, viewModel) {
        ko.utils.extend(this, data);
        var self = this;

        self.viewModel = viewModel;
        self.count = ko.observable(0);
        self.type = types[data.type];
        self.unreadAvatars = ko.observableArray([]);
        self.readAvatars = ko.observableArray([]);
        self.unreadEntities = ko.observableArray([]);
        self.readEntities = ko.observableArray([]);
        self.entities = ko.computed(function() {
            return self.viewModel.tab() == 0 ? self.unreadEntities() : self.readEntities();
        });

        self.title = ko.computed(function() {
            if (self.entity.type == 'comment' || self.type == 'comment') {
                if (self.entities() && self.entities()[0])
                    return self.entities()[0].title;
            }
            return self.entity.title;
        });
        self.tooltip = ko.computed(function() {
            return '';
        });

        self.setReaded = function() {
            self.request.send(self.id);
        };
        self.avatars = ko.computed(function() {
            return self.viewModel.tab() == 0 ? self.unreadAvatars() : self.readAvatars();
        });

        self.update = function(data) {
            self.count(self.viewModel.tab() == 1 ? data.readCount : data.unreadCount);
            self.readed = ko.observable(false);

            var unreadAvatars = [];
            for (var userId in data.unreadAvatars) {
                unreadAvatars.push(new User(userId, data.unreadAvatars[userId]));
            }
            self.unreadAvatars(unreadAvatars);

            var readAvatars = [];
            for (var userId in data.readAvatars) {
                readAvatars.push(new User(userId, data.readAvatars[userId]));
            }
            self.readAvatars(readAvatars);

            self.readEntities(data.readEntities);
            self.unreadEntities(data.unreadEntities);
        }
        self.update(data);

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
        self.addNotification = function(data) {
            var signal = new Notify(data, self);
            self.notifications.unshift(signal);
            return signal;
        };
        self.addNotifications(data.list);
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