function FriendsViewModel(data) {
    var self = this;

    self.friendsCount = ko.observable(data.friendsCount);
    self.friendsOnlineCount = ko.observable(data.friendsOnlineCount);
    self.incomingRequestsCount = ko.observable(data.incomingRequestsCount);
    self.outgoingRequestsCount = ko.observable(data.outgoingRequestsCount);
    self.lists = ko.observableArray(ko.utils.arrayMap(data.lists, function(list) {
        return new List(list, self);
    }));
    self.selectedListId = ko.observable(null);
    self.friendsToShow = ko.observableArray([]);
    self.activeTab = ko.observable(0);

    self.activeTab.subscribe(function () {
        self.load();
    });

    self.selectAll = function() {
        self.selectedListId(null);
    }

    self.selectTab = function(tab) {
        self.activeTab(tab);
    }

    self.getListById = function(listId) {
        return ko.utils.arrayFirst(self.lists(), function(list) {
            return listId == list.id();
        });
    }

    self.load = function() {
        var data = {};
        if (self.activeTab() === 1)
            data.online = 1;
        if (self.selectedListId !== null)
            data.listId = self.selectedListId();

        $.get('/friends/default/get/', data, function(response) {
            self.friendsToShow(ko.utils.arrayMap(response.friends, function(friend) {
                return new Friend(friend, self);
            }));
        }, 'json');
    }

    self.load();
}

function Friend(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.online = ko.observable(data.online);
    self.firstName = ko.observable(data.firstName);
    self.lastName = ko.observable(data.lastName);
    self.listId = ko.observable(data.listId);

    self.fullName = ko.computed(function() {
        return self.firstName() + ' ' + self.lastName();
    });

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
}

function List(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.friendsCount = ko.observable(data.friendsCount);
    self.title = ko.observable(data.title);

    self.select = function(list) {
        parent.selectedListId(list.id());
    }

    self.inc = function() {
        self.friendsCount(self.friendsCount() + 1);
    }

    self.dec = function() {
        self.friendsCount(self.friendsCount() - 1);
    }
}