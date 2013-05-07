function FriendsViewModel(data) {
    var self = this;

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
    self.newListTitle = ko.observable('');
    self.searchQuery = ko.observable('');
    self.loading = ko.observable(false);
    self.lastPage = ko.observable(false);
    self.friendsRequests = ko.observableArray([]);
    self.newSelected = ko.observable(false);

    self.clearSearchQuery = function() {
        self.searchQuery('');
    }

    self.selectAll = function() {
        self.newSelected(false);
        self.activeTab(0);
        self.selectedListId(null);
        self.init();
    }

    self.selectNew = function() {
        self.newSelected(true);
        self.activeTab(0);
        self.selectedListId(null);
        self.init();
    }

    self.selectTab = function(tab) {
        self.newSelected(false);
        self.selectedListId(null);
        self.activeTab(tab);
        self.init();
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

    self.searchQuery.subscribe(function() {
        self.init();
    });

    self.loadFriends = function(callback, offset) {
        self.loading(true);

        var data = {};
        if (self.activeTab() === 1)
            data.online = 1;
        if (self.selectedListId() !== null)
            data.listId = self.selectedListId();
        if (self.searchQuery() !== '')
            data.query = self.searchQuery();
        if (typeof offset !== "undefined")
            data.offset = offset;
        if (self.newSelected() === true)
            data.new = 1;

        $.get('/friends/default/get/', data, function(response) {
            callback(response);
            self.loading(false);
            if (response.last)
                self.lastPage(true);
        }, 'json');
    }

    self.init = function() {
        self.friendsToShow([]);
        self.friendsRequests([]);

        if (self.activeTab() != 2) {
            self.lastPage(false);
            self.loadFriends(function(response) {
                self.friendsToShow(ko.utils.arrayMap(response.friends, function(friend) {
                    return new Friend(friend, self);
                }))
            });
        } else {
            $.get('/friends/requests/get/', function(response){
                self.friendsRequests(ko.utils.arrayMap(response.requests, function(request) {
                    return new FriendRequest(request, self);
                }));
            }, 'json');
        }
    }

    self.nextPage = function() {
        self.loadFriends(function(response) {
            var newItems = ko.utils.arrayMap(response.friends, function(friend) {
                return new Friend(friend, self);
            });

            self.friendsToShow.push.apply(self.friendsToShow, newItems);
        }, self.friendsToShow().length);
    }

    self.init();

    $('.layout-container').scroll(function() {
        if (self.activeTab() != 2 && self.loading() === false && self.lastPage() === false && (($('.layout-container').scrollTop() + $('.layout-container').height()) > ($('.layout-container').prop('scrollHeight') - 200)))
            self.nextPage();
    });
}

function Friend(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.listId = ko.observable(data.listId);
    self.user = ko.observable(new User(data.user, parent));

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
        $.post('/friends/default/delete/', { friendId : self.user().id() }, function(response) {
            if (response.success) {
                parent.friendsCount(parent.friendsCount() - 1);
                if (self.user().online())
                    parent.friendsOnlineCount(parent.friendsOnlineCount() - 1);
                if (self.listId !== null) {
                    var list = ko.utils.arrayFirst(parent.lists(), function(list) {
                        return list.id() == self.listId();
                    });
                    list.dec();
                }
                parent.friendsToShow.remove(self);
            }
        }, 'json');
    }
}

function FriendRequest(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.fromId = ko.observable(data.fromId);
    self.user = ko.observable(new User(data.user, parent));

    self.accept = function(request) {
        $.post('/friends/requests/accept/', { requestId : self.id() }, function(response) {
            if (response.success) {
                parent.friendsRequests.remove(request);
                parent.friendsCount(parent.friendsCount() + 1);
                parent.friendsNewCount(parent.friendsNewCount() + 1);
                parent.incomingRequestsCount(parent.incomingRequestsCount() - 1);
                if (self.user().online())
                    parent.friendsOnlineCount(parent.friendsOnlineCount() + 1);
            }
        }, 'json');
    }

    self.decline = function(request) {
        $.post('/friends/requests/decline/', { requestId : self.id() }, function(response) {
            if (response.success) {
                parent.friendsRequests.remove(request);
                parent.incomingRequestsCount(parent.incomingRequestsCount() + 1);
            }
        }, 'json');
    }
}

function User(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.online = ko.observable(data.online);
    self.firstName = ko.observable(data.firstName);
    self.lastName = ko.observable(data.lastName);
    self.ava = ko.observable(data.ava);

    self.fullName = ko.computed(function() {
        return self.firstName() + ' ' + self.lastName();
    });

    self.url = ko.computed(function() {
        return '/user/' + self.id() + '/';
    });

    self.dialogUrl = ko.computed(function() {
        return '/messaging/?interlocutorId=' + self.id();
    });

    self.albumsUrl = ko.computed(function() {
        return '/user/' + self.id() + '/albums/';
    });

    self.blogUrl = ko.computed(function() {
        return '/user/' + self.id() + '/blog/';
    });
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