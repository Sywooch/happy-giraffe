function Interlocutor(data) {
    var self = this;

    self.user = new User(data.user);
    self.blogPostsCount = ko.observable(data.blogPostsCount);
    self.photosCount = ko.observable(data.photosCount);
}

function User(data) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);

    self.fullName = ko.computed(function() {
        return self.firstName() + ' ' + self.lastName();
    }, this);

    self.avatarClass = ko.computed(function() {
        return self.gender() == 0 ? 'female' : 'male';
    }, this);
}

function Thread(data) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);
}

function Contact(data) {
    var self = this;

    self.user = ko.observable(new User(data.user));
    self.thread = ko.observable(data.thread == null? null : new Thread(data.thread));
}

function Message(data, parent) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);

    self.author = ko.computed(function() {
        return self.author_id() == parent.me.id() ? parent.me : parent.interlocutor().user;
    });
}

function MessagingViewModel(data) {
    var self = this;

    self.tab = ko.observable(0);
    self.searchQuery = ko.observable('');
    self.contacts = ko.observableArray([]);
    self.messages = ko.mapping.fromJS([]);
    self.openContact = ko.observable('');
    self.interlocutor = ko.observable('');
    self.me = new User(data.me);
    self.loading = ko.observable(false);

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

        $.get('/messaging/interlocutors/get/', { interlocutorId : contact.user().id() }, function(response) {
            self.interlocutor(new Interlocutor(response.interlocutor));
        }, 'json');

        $.get('/messaging/threads/getMessages', { threadId : contact.thread().id() }, function(response) {
            ko.mapping.fromJS(response, {
                'messages': {
                    create: function(options) {
                        return new Message(options.data, self);
                    }
                }
            }, self);
        }, 'json');
    }

    self.allContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return contact.thread() != null || contact.user().id() == data.interlocutorId;
        });
    }, this);

    self.newContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return contact.thread() != null && contact.thread().unreadCount() > 0;
        });
    }, this);

    self.onlineContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return contact.thread() != null && contact.user().online();
        });
    }, this);

    self.friendsContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return contact.user().isFriend();
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
            if (l.thread() !== null && r.thread() !== null)
                return l.thread().updated() == r.thread().updated() ? 0 : (l.thread().updated() > r.thread().updated() ? -1 : 1);

            if (l.thread() === null && r.thread() === null)
                return 0;

            if (l.thread() !== null && r.thread() === null)
                return -1;

            if (l.thread() === null && r.thread() !== null)
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

    self.messagesToShow = ko.computed(function() {
        return self.messages().sort(function(l, r) {
            return l.id() == r.id() ? 0 : (l.id() > r.id() ? 1 : -1);
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

    self.preload = function() {
        self.loading(true);
        $.get('/messaging/threads/getMessages', { threadId : self.openContact().thread.id, offset: self.messages().length }, function(response) {
            ko.mapping.fromJS(response, {
                'messages': {
                    create: function(options) {
                        self.messages.push(new Message(options.data, self));
                    }
                }
            });
            self.loading(false);
        }, 'json');
    }

    self.sendMessage = function() {
        var data = {}
        data.interlocutorId = self.interlocutor().user.id();
        data.text = CKEDITOR.instances['im-editor'].getData();
        if (typeof(self.openContact().thread) == 'object')
            data.threadId = self.openContact().thread.id();

        $.post('/messaging/messages/send/', data, function(response) {
            self.messages.push(new Message(response.message, self));
            CKEDITOR.instances['im-editor'].setData('');
            if (typeof(self.openContact().thread) != 'object') {
                console.log(self.openContact());
                console.log(response.thread);
                self.openContact().thread(response.thread);
                self.openContact().user.first_name('123');
                console.log(self.openContact());
                console.log(self.friendsContacts());
            }
        }, 'json');
    }

    ko.utils.arrayForEach(data.contacts, function(contact) {
        self.contacts.push(new Contact(contact));
    });
//    console.log(self.contacts());

//    self.openThread(data.interlocutorId == null ? self.visibleContactsToShow()[0] : self.findByInterlocutorId(data.interlocutorId));

    $(function() {
        var container = $('.layout-container');

        container.scroll(function() {
            var scrollBottom = container.prop('scrollHeight') - container.scrollTop() - container.height();

            if (self.loading() === false && scrollBottom < 100)
                self.preload();
        });
    });
}