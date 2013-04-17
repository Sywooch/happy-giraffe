function Interlocutor(data, parent) {
    var self = this;

    self.user = new User(data.user, parent);
    self.blogPostsCount = ko.observable(data.blogPostsCount);
    self.photosCount = ko.observable(data.photosCount);
}

function User(data, parent) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);

    self.fullName = ko.computed(function() {
        return self.firstName() + ' ' + self.lastName();
    }, this);

    self.avatarClass = ko.computed(function() {
        return self.gender() == 0 ? 'female' : 'male';
    }, this);
}

function Thread(data, parent) {
    var self = this;

    self.deleteMessages = function() {
        $.post('/messaging/threads/deleteMessages/', { threadId : self.id() }, function(response) {
            if (response.success)
                parent.messages.removeAll();
        }, 'json')
    }

    self.inc = function() {
        self.unreadCount(self.unreadCount() + 1);
    }

    ko.mapping.fromJS(data, {}, self);
}

function Contact(data, parent) {
    var self = this;

    self.user = ko.observable(new User(data.user, parent));
    self.thread = ko.observable(data.thread == null? null : new Thread(data.thread, parent));
}

function Message(data, parent) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);

    self.delete = function() {
        $.post('/messaging/messages/delete/', { messageId : self.id() }, function(response) {
            if (response.success)
                parent.messages.remove(self);
        }, 'json');
    }

    self.author = ko.computed(function() {
        return self.author_id() == parent.me.id() ? parent.me : parent.interlocutor().user;
    });
}

function MessagingViewModel(data) {
    var self = this;

    self.tab = ko.observable(0);
    self.searchQuery = ko.observable('');
    self.contacts = ko.observableArray(ko.utils.arrayMap(data.contacts, function(contact) {
        return new Contact(contact, self);
    }));
    self.messages = ko.observableArray([]);
    self.openContactIndex = ko.observable('');
    self.interlocutor = ko.observable('');
    self.me = new User(data.me, self);
    self.loadingMessages = ko.observable(false);
    self.sendingMessage = ko.observable(false);
    self.interlocutorTyping = ko.observable(false);

    self.enterSetting = ko.observable(data.settings.messaging__enter);
    self.enterSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__enter', value : a ? 1 : 0 });
    });

    self.soundSetting = ko.observable(data.settings.messaging__sound);
    self.soundSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__sound', value : a ? 1 : 0 });
    });
    self.toggleSoundSetting = function() {
        self.soundSetting(! self.soundSetting());
    }

    self.interlocutorExpandedSetting = ko.observable(data.settings.messaging__interlocutorExpanded);
    self.interlocutorExpandedSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__interlocutorExpanded', value : a ? 1 : 0 });
    });
    self.toggleinterlocutorExpandedSetting = function() {
        self.interlocutorExpandedSetting(! self.interlocutorExpandedSetting());
    }

    self.changeHiddenStatus = function(contact) {
        var newHiddenStatus = contact.thread().hidden() ? 0 : 1;
        $.post('/messaging/threads/changeHiddenStatus/', { threadId : contact.thread().id, hiddenStatus: newHiddenStatus }, function(response) {
            contact.thread().hidden(newHiddenStatus);
        }, 'json');
    }

    self.changeReadStatus = function(contact) {
        var newReadStatus = contact.thread().unreadCount() == 0 ? 0 : 1;
        var newUnreadCount = contact.thread().unreadCount() == 0 ? 1 : 0;
        $.post('/messaging/threads/changeReadStatus/', { threadId : contact.thread().id, readStatus: newReadStatus }, function(response) {
            contact.thread().unreadCount(newUnreadCount);
        }, 'json');
    }

    self.openThread = function(contact) {
        self.openContactIndex(self.contacts().indexOf(contact));

        $.get('/messaging/interlocutors/get/', { interlocutorId : contact.user().id() }, function(response) {
            self.interlocutor(new Interlocutor(response.interlocutor, self));
        }, 'json');

        if (self.openContact().thread() === null)
            self.messages([]);
        else
            $.get('/messaging/threads/getMessages/', { threadId : contact.thread().id() }, function(response) {
                self.messages(ko.utils.arrayMap(response.messages, function(message) {
                    return new Message(message, self);
                }));
            }, 'json');
    }

    self.openContact = ko.computed(function() {
        return ko.utils.arrayFirst(self.contacts(), function(contact) {
            return self.contacts().indexOf(contact) === self.openContactIndex();
        });
    }, this);

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
                return contact.user().fullName().toLowerCase().indexOf(query.toLowerCase()) != -1;
            });
    });

    self.visibleContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return contact.thread() === null || ! contact.thread().hidden();
        });
    });

    self.hiddenContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return contact.thread() !== null && contact.thread().hidden();
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
            return contact.user().id() == interlocutorId;
        });
    }

    self.preload = function() {
        var startHeight = im.container.get(0).scrollHeight;
        var startTop = im.container.scrollTop();
        self.loadingMessages(true);
        $.get('/messaging/threads/getMessages/', { threadId : self.openContact().thread().id, offset: self.messages().length }, function(response) {
            ko.utils.arrayForEach(response.messages, function(message) {
                self.messages.push(new Message(message, self));
            });
            self.loadingMessages(false);
            var endHeight = im.container.get(0).scrollHeight;
            im.container.scrollTop(endHeight - startHeight + startTop);
        }, 'json');
    }

    self.sendMessage = function() {
        self.sendingMessage(true);

        var data = {}
        data.interlocutorId = self.interlocutor().user.id();
        data.text = CKEDITOR.instances['im-editor'].getData();
        if (self.openContact().thread() !== null)
            data.threadId = self.openContact().thread().id();

        $.post('/messaging/messages/send/', data, function(response) {
            self.messages.push(new Message(response.message, self));
            CKEDITOR.instances['im-editor'].setData('');
            if (self.openContact().thread() === null)
                self.openContact().thread(new Thread(response.thread, self));
            else
                self.openContact().thread().updated(response.time);

            self.sendingMessage(false);
            im.container.scrollTop($('.layout-container_hold').height());
        }, 'json');
    }

    self.openThread(data.interlocutorId == null ? self.visibleContactsToShow()[0] : self.findByInterlocutorId(data.interlocutorId));

    soundManager.setup({
        url: '/swf/',
        debugMode: false,
        onready: function() {
            soundManager.createSound({ id : 's', url : '/audio/1.mp3' });
        }
    });

    $(function() {
        CKEDITOR.instances['im-editor'].on('focus', function() {
            $.post('/messaging/interlocutors/typing/', { typingStatus : 1, interlocutorId : self.interlocutor().user.id() });
        });

        CKEDITOR.instances['im-editor'].on('blur', function() {
            $.post('/messaging/interlocutors/typing/', { typingStatus : 0, interlocutorId : self.interlocutor().user.id() });
        });

        Comet.prototype.receiveMessage = function (result, id) {
            var contact = self.findByInterlocutorId(result.contact.user.id);
            if (contact === null) {
                contact = new Contact(result.contact, self);
                self.contacts.push(contact);
            } else if (contact.thread() === null) {
                contact.thread(new Thread(result.contact.thread, self))
            } else
                contact.thread().updated(result.time);

            contact.thread().inc();
            if (self.openContact().user().id() == contact.user().id())
                self.messages.push(new Message(result.message, self));

            if (self.soundSetting())
                soundManager.play('s');
            im.container.scrollTop($('.layout-container_hold').height());
        }

        Comet.prototype.typingStatus = function (result, id) {
            console.log(result);
            self.interlocutorTyping(result.typingStatus);
        }

        comet.addEvent(2000, 'receiveMessage');
        comet.addEvent(2001, 'typingStatus');
    });

    $(window).load(function() {
        self.messages.subscribe(function() {
            im.holdHeights();
        });

        im.container.scroll(function() {
            if (self.loadingMessages() === false && im.container.scrollTop() < 200)
                self.preload();
        });
    });
}