function Interlocutor(data) {
    self = ko.mapping.fromJS(data);
}

function MessagingViewModel(data) {
    var self = this;

    self.tab = ko.observable(0);
    self.searchQuery = ko.observable('');
    self.contacts = ko.mapping.fromJS(data.contacts);

    self.openContact = ko.observable();
    self.interlocutor = ko.observable();

    self.changeHiddenStatus = function(contact) {
        var newHiddenStatus = contact.thread.hidden() ? 0 : 1;
        $.post('/messaging/threads/changeHiddenStatus/', { threadId : contact.thread.id, hiddenStatus: newHiddenStatus }, function(response) {
            contact.thread.hidden(newHiddenStatus);
        }, 'json');
    }

    self.changeReadStatus = function(contact) {
        var newReadStatus = contact.thread.unreadCount() == 0 ? 0 : 1;
        var newUnreadCount = contact.thread.unreadCount() == 0 ? 1 : 0;
        $.post('/messaging/threads/changeReadStatus/', { threadId : contact.thread.id, readStatus: newReadStatus }, function(response) {
            contact.thread.unreadCount(newUnreadCount);
        }, 'json');
    }

    self.openThread = function(contact) {
        self.openContact(contact);
        $.get('/messaging/interlocutors/get/', { interlocutorId : 22 }, function(response) {
            self.interlocutor(new Interlocutor(response.interlocutor));
        }, 'json');
    }

    self.allContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return typeof(contact.thread) == 'object';
        });
    }, this);

    self.newContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.allContacts(), function(contact) {
            return contact.thread.unreadCount() > 0;
        });
    }, this);

    self.onlineContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.allContacts(), function(contact) {
            return contact.user.online();
        });
    }, this);

    self.friendsContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return contact.user.isFriend();
        });
    }, this);

    self.contactsToShow = ko.computed(function() {
        switch (self.tab()) {
            case 0:
                var contacts = self.allContacts();
                break;
            case 1:
                var contacts = self.newContacts();
                break;
            case 2:
                var contacts = self.onlineContacts();
                break;
            case 3:
                var contacts = self.friendsContacts();
                break;
        }

        contacts.sort(function(l, r) {
            if (typeof(l.thread) == 'object' && typeof(r.thread) == 'object')
                return l.thread.updated() == r.thread.updated() ? 0 : (l.thread.updated() > r.thread.updated() ? -1 : 1);

            if (typeof(l.thread) != 'object' && typeof(r.thread) != 'object')
                return 0;

            if (typeof(l.thread) == 'object' && typeof(r.thread) != 'object')
                return -1;

            if (typeof(l.thread) != 'object' && typeof(r.thread) == 'object')
                return 1;
        });

        var query = self.searchQuery();
        return (query == '') ?
            contacts
            :
            ko.utils.arrayFilter(contacts, function(contact) {
                var name = (contact.user.first_name() + ' ' + contact.user.last_name());
                return name.toLowerCase().indexOf(query.toLowerCase()) != -1;
            });
    });

    self.visibleContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return typeof(contact.thread) != 'object' || ! contact.thread.hidden();
        });
    });

    self.hiddenContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return typeof(contact.thread) == 'object' && contact.thread.hidden();
        });
    });

    self.changeTab = function(tab) {
        self.tab(tab);
    }

    self.openThread(self.visibleContactsToShow()[0]);
}