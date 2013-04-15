function Interlocutor(data) {
    var self = this;

    self.id = ko.observable(data.id);
    self.firstName = ko.observable(data.firstName);
    self.lastName = ko.observable(data.lastName);
    self.online = ko.observable(data.online);
    self.avatar = ko.observable(data.avatar);
    self.blogPostsCount = ko.observable(data.blogPostsCount);
    self.photosCount = ko.observable(data.photosCount);
    self.isFriend = ko.observable(data.isFriend);

    self.fullName = ko.computed(function() {
        return self.firstName() + ' ' + self.lastName();
    }, this);
}

function MessagingViewModel(data) {
    var self = this;

    self.tab = ko.observable(0);
    self.searchQuery = ko.observable('');
    self.contacts = ko.mapping.fromJS(data.contacts);

    self.openContact = ko.observable('');
    self.interlocutor = ko.observable(new Interlocutor({}));

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

        $.get('/messaging/interlocutors/get/', { interlocutorId : contact.user.id() }, function(response) {
            self.interlocutor(new Interlocutor(response.interlocutor));
        }, 'json');
    }

    self.allContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return typeof(contact.thread) == 'object' || contact.user.id() == data.interlocutorId;
        });
    }, this);

    self.newContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return typeof(contact.thread) == 'object' && contact.thread.unreadCount() > 0;
        });
    }, this);

    self.onlineContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return typeof(contact.thread) == 'object' && contact.user.online();
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

    self.findByInterlocutorId = function(interlocutorId) {
        return ko.utils.arrayFirst(self.contacts(), function(contact) {
            return contact.user.id() == interlocutorId;
        });
    }

    self.openThread(data.interlocutorId == null ? self.visibleContactsToShow()[0] : self.findByInterlocutorId(data.interlocutorId));

    console.log(self.contactsToShow().length);
}