(function() {
    function f(ko) {
        function FriendsViewModel(data) {
            var self = this;

            var REQUEST_TYPE_INCOMING = 0;
            var REQUEST_TYPE_OUTGOING = 1;

            self.friendsCount = ko.observable(data.friendsCount);
            self.friendsOnlineCount = ko.observable(data.friendsOnlineCount);
            self.incomingRequestsCount = ko.observable(data.incomingRequestsCount);
            self.outgoingRequestsCount = ko.observable(data.outgoingRequestsCount);
            self.friendsNewCount = ko.observable(data.friendsNewCount);
            self.lists = ko.observableArray(ko.utils.arrayMap(data.lists, function(list) {
                return new List(list, self);
            }));
            self.selectedListId = ko.observable(null);
            self.friendsToShow = ko.observableArray([]);

            self.activeTab = ko.observable(self.incomingRequestsCount() > 0 ? 2 : 0);
            var params = /(\?|&)tab=(\d+)/.exec(window.location.search);
            if(params && params[2]) {
                self.activeTab(params[2] * 1);
            }

            self.newListTitle = ko.observable('');
            self.instantaneousQuery = ko.observable('');
            self.query = ko.computed(this.instantaneousQuery).extend({ throttle: 400 });
            self.loading = ko.observable(false);
            self.lastPage = ko.observable(false);
            self.friendsRequests = ko.observableArray([]);
            self.newSelected = ko.observable(false);

            self.clearSearchQuery = function() {
                self.instantaneousQuery('');
            }

            self.selectAll = function() {
                self.newSelected(false);
                self.activeTab(0);
                self.selectedListId(null);
            }

            self.selectNew = function() {
                self.newSelected(true);
                self.activeTab(0);
                self.selectedListId(null);
            }

            self.selectTab = function(tab) {
                self.newSelected(false);
                self.selectedListId(null);
                History.pushState(null, window.document.title, '?tab=' + tab);
                self.activeTab(tab);
            }

            self.getListById = function(listId) {
                return ko.utils.arrayFirst(self.lists(), function(list) {
                    return listId == list.id();
                });
            }

            self.addListHandler = function(data, event) {
                if (event.keyCode == 13)
                    self.addList();
                return true;
            }

            self.addList = function() {
                $.post('/friends/lists/create/', { title : self.newListTitle() }, function(response) {
                    if (response.success) {
                        self.lists.push(new List(response.list, self));
                        self.newListTitle('');
                        $('#addList').show();
                        $('#addListForm').hide();
                    }
                }, 'json');
            }

            self.query.subscribe(function() {
                self.init();
            });

            self.loadFriends = function(callback, offset) {
                var data = {};
                if (self.activeTab() === 1)
                    data.online = 1;
                if (self.selectedListId() !== null)
                    data.listId = self.selectedListId();
                if (self.query() !== '')
                    data.query = self.query();
                if (typeof offset !== "undefined")
                    data.offset = offset;
                if (self.newSelected() === true)
                    data.onlyNew = 1;

                self.loading(true);
                $.get('/friends/default/get/', data, function(response) {
                    self.loading(false);
                    callback(response);
                    if (response.last)
                        self.lastPage(true);
                }, 'json');
            };

            self.init = function() {
                if (self.activeTab() <= 1) {
                    self.lastPage(false);
                    self.loadFriends(function(response) {
                        self.friendsToShow(ko.utils.arrayMap(response.friends, function(friend) {
                            return new Friend(friend, self);
                        }))
                    });
                } else {
                    self.loading(true);
                    $.get('/friends/requests/get/', { type : (self.activeTab() == 2) ? REQUEST_TYPE_INCOMING : REQUEST_TYPE_OUTGOING } , function(response) {
                        self.loading(false);
                        self.friendsRequests(ko.utils.arrayMap(response.requests, function(request) {
                            if (self.activeTab() == 2)
                                return new IncomingFriendRequest(request, self);
                            else {
                                request.invited = true;
                                return new OutgoingFriendRequest(request, self);
                            }
                        }));
                    }, 'json');
                }
            }

            self.nextPage = function() {
                if (self.activeTab() <= 1) {
                    self.loadFriends(function(response) {
                        var newItems = ko.utils.arrayMap(response.friends, function(friend) {
                            return new Friend(friend, self);
                        });

                        self.friendsToShow.push.apply(self.friendsToShow, newItems);
                    }, self.friendsToShow().length);
                }
            }

            self.templateName = function() {
                return self.activeTab() <= 1 ? 'user-template' : 'request-template';
            }

            self.templateForeach = ko.computed(function() {
                return self.activeTab() <= 1 ? self.friendsToShow() : self.friendsRequests();
            })

            //self.init();

            $(window).scroll(function() {
                if (self.activeTab() <= 1 && self.loading() === false && self.lastPage() === false && (($(window).scrollTop() + $(window).height()) > (document.documentElement.scrollHeight - 500)))
                    self.nextPage();
            });

            ko.computed(function() {
                self.init();
                self.newSelected();
                self.selectedListId();
                self.activeTab();
                self.friendsToShow([]);
                self.friendsRequests([]);
            })
        }

        function Friend(data, parent) {
            var self = this;

            self.id = ko.observable(data.id);
            self.listId = ko.observable(data.listId);
            self.user = new FriendsUser(data.user, parent);
            self.pCount = ko.observable(data.pCount);
            self.bCount = ko.observable(data.bCount);
            self.removed = ko.observable(false);

            self.listLabel = ko.computed(function() {
                return self.listId() === null ? 'Все друзья' : parent.getListById(self.listId()).title();
            });

            self.bindList = function(list) {
                $.post('/friends/lists/bind/', { friendId : self.id(), listId : list.id() }, function(response) {
                    if (response.success) {
                        if (self.listId() !== null)
                            parent.getListById(self.listId()).dec();

                        self.listId(list.id());
                        list.inc();
                    }
                }, 'json');
            }

            self.unbindList = function() {
                $.post('/friends/lists/unbind/', { friendId : self.id() }, function(response) {
                    if (response.success) {
                        if (self.listId() !== null)
                            parent.getListById(self.listId()).dec();

                        self.listId(null);
                    }
                }, 'json');
            }

            self.remove = function() {
                $.post('/friends/default/delete/', { friendId : self.user.id }, function(response) {
                    if (response.success) {
                        parent.friendsCount(parent.friendsCount() - 1);
                        if (self.user.online)
                            parent.friendsOnlineCount(parent.friendsOnlineCount() - 1);
                        if (self.listId() !== null) {
                            var list = ko.utils.arrayFirst(parent.lists(), function(list) {
                                return list.id() == self.listId();
                            });
                            list.dec();
                        }
                        self.removed(true);
                    }
                }, 'json');
            }

            self.restore = function() {
                $.post('/friends/default/restore/', { friendId : self.user.id }, function(response) {
                    if (response.success) {
                        parent.friendsCount(parent.friendsCount() + 1);
                        if (self.user.online)
                            parent.friendsOnlineCount(parent.friendsOnlineCount() + 1);
                        if (self.listId() !== null) {
                            var list = ko.utils.arrayFirst(parent.lists(), function(list) {
                                return list.id() == self.listId();
                            });
                            list.inc();
                        }
                        self.removed(false);
                    }
                }, 'json');
            }
        }

        function FriendRequest(data, parent) {
            var self = this;

            self.id = data.id;
            self.user = new FriendsUser(data.user, parent);
        }

        function IncomingFriendRequest(data, parent) {
            var self = this;
            self.type = 'incoming';
            ko.utils.extend(self, new FriendRequest(data, parent));

            self.fromId = ko.observable(data.fromId);
            self.removed = ko.observable(false);
            self.accepted = ko.observable(false);
            self.userIsVisible = ko.observable(true);

            self.accept = function() {
                $.post('/friends/requests/accept/', { requestId : self.id }, function(response) {
                    if (response.success) {
                        //parent.friendsRequests.remove(self);
                        self.accepted(true);
                        setTimeout(function () {
                            if (self.accepted()) {
                                self.userIsVisible(false);
                                //parent.friendsRequests.remove(self);
                            }
                        }, 2000);
                        parent.friendsCount(parent.friendsCount() + 1);
                        parent.friendsNewCount(parent.friendsNewCount() + 1);
                        parent.incomingRequestsCount(parent.incomingRequestsCount() - 1);
                        if (self.user.online)
                            parent.friendsOnlineCount(parent.friendsOnlineCount() + 1);

                        if (parent.incomingRequestsCount() == 0)
                            parent.selectTab(0);


                    }
                }, 'json');
            }

            self.decline = function() {
                $.post('/friends/requests/decline/', { requestId : self.id }, function(response) {
                    if (response.success) {
                        parent.incomingRequestsCount(parent.incomingRequestsCount() - 1);
                        self.removed(true);
                        setTimeout(function () {
                            if (self.removed()) {
                                self.userIsVisible(false);
                                //parent.friendsRequests.remove(self);
                            }
                        }, 2000);
                    }
                }, 'json');
            }

            self.restore = function() {
                $.post('/friends/requests/restore/', { requestId : self.id }, function(response) {
                    if (response.success) {
                        self.removed(false);
                        self.userIsVisible(true);
                        parent.incomingRequestsCount(parent.incomingRequestsCount() + 1);
                    }
                }, 'json');
            }
        }

        function OutgoingFriendRequest(data, parent) {
            var self = this;
            self.type = 'outgoing';
            ko.utils.extend(self, new FriendRequest(data, parent));

            self.invited = ko.observable(data.invited);
            self.userIsVisible = ko.observable(true);

            self.invite = function() {
                $.post('/friendRequests/send/', { to_id : self.user.id }, function(response) {
                    if (response.status){
                        self.invited(true);
                        setTimeout(function () {
                            self.userIsVisible(false);
                        }, 2000);
                    }
                }, 'json');
            }

            self.cancel = function() {
                $.post('/friends/requests/cancel/', { toId : self.user.id }, function(response) {
                    if (response.success)
                        self.invited(false);
                }, 'json');
            }

            self.clickHandler = function() {
                self.invited() ? self.cancel() : self.invite();
            }

            self.aCssClass = ko.computed(function() {
                return self.invited() ? 'b-ava-large_bubble__friend-added' : 'b-ava-large_bubble__friend-add';
            });

            self.spanCssClass = ko.computed(function() {
                return self.invited() ? 'b-ava-large_ico__friend-added' : 'b-ava-large_ico__friend-add';
            });

            self.tooltipText = ko.computed(function() {
                return self.invited() ? 'Отменить приглашение' : 'Добавить в друзья';
            });
        }

        function FriendsUser(data, parent) {
            var self = this;

            self.id = data.id;
            self.online = data.online;
            self.firstName = data.firstName;
            self.lastName = data.lastName;
            self.ava = data.ava;
            self.gender = data.gender;
            self.age = data.age;
            self.location = data.location;
            self.family = data.family;
            self.blogPostsCount = data.blogPostsCount;
            self.photoCount = data.photoCount;

            self.hasBlog = ko.computed(function () {
                return self.blogPostsCount > 0;
            });
            self.hasPhotos = ko.computed(function () {
                return self.photoCount > 1;
            });

            self.fullName = function() {
                return self.firstName + ' ' + self.lastName;
            };

            self.url = function() {
                return '/user/' + self.id + '/';
            };

            self.dialogUrl = function() {
                return '/messaging/?interlocutorId=' + self.id;
            };

            self.albumsUrl = function() {
                return '/user/' + self.id + '/albums/';
            };

            self.blogUrl = function() {
                return '/user/' + self.id + '/blog/';
            };

            self.avaClass = function() {
                return self.gender == 1 ? 'male' : 'female';
            };
        }

        function List(data, parent) {
            var self = this;

            self.id = ko.observable(data.id);
            self.friendsCount = ko.observable(data.friendsCount);
            self.title = ko.observable(data.title);

            self.select = function(list) {
                parent.newSelected(false);
                parent.activeTab(0);
                parent.selectedListId(list.id());
                parent.init();
            }

            self.remove = function(list) {
                $.post('/friends/lists/delete/', { listId : list.id() }, function(response) {
                    if (response.success)
                        parent.lists.remove(list);
                }, 'json');
            }

            self.inc = function() {
                self.friendsCount(self.friendsCount() + 1);
            }

            self.dec = function() {
                self.friendsCount(self.friendsCount() - 1);
            }
        }

        window.Friend = Friend;
        window.FriendRequest = FriendRequest;
        window.FriendUser = FriendsUser;
        window.IncomingFriendRequest = IncomingFriendRequest;
        window.OutgoingFriendRequest = OutgoingFriendRequest;

        return FriendsViewModel;
    };
    if (typeof define === 'function' && define['amd']) {
        define('ko_friends', ['knockout', 'ko_library', 'history2'], f);
    } else {
        window.FriendsViewModel = f(window.ko);
    }
})(window);
