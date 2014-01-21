// Модель собеседника
function Interlocutor(data, parent) {
    var self = this;
	// Модель пользователя
    self.user = ko.observable(new User(data.user, parent));
	// Доп. атрибуты
    self.blogPostsCount = ko.observable(data.blogPostsCount);
    self.photosCount = ko.observable(data.photosCount);
    self.inviteSent = ko.observable(data.inviteSent);
    self.isBlocked = ko.observable(data.isBlocked);

    self.toBlackList = ko.observable(false);

    self.blockHandler = function() {
        if (parent.blackListSetting())
            self.addToBlackList();
        else
            self.toBlackList(! self.toBlackList());
    }

    self.yesHandler = function() {
        self.addToBlackList();
        self.toBlackList(false);
    }

    self.noHandler = function() {
        self.toBlackList(false);
    }

    self.addToBlackList = function() {
        $.post('/messaging/interlocutors/blackList/', { interlocutorId : self.user().id() }, function(response) {
            if (response.success) {
                self.toBlackList(false);
                var contact = parent.findByInterlocutorId(self.user().id());
                parent.contacts.remove(contact);
                if (parent.contactsToShow().length > 0)
                    parent.openThread(parent.contactsToShow()[0]);
            }
        }, 'json');
    }

}
// Модель пользователя
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
// Модель диалога
function Thread(data, parent) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);

    self.deleteMessages = function() {
        $.post('/messaging/threads/deleteMessages/', { threadId : self.id() }, function(response) {
            if (response.success)
                parent.messages.removeAll();
        }, 'json')
    }

    self.toggleReadStatus = function() {
        self.changeReadStatus(self.unreadCount() == 0 ? 0 : 1);
    }

    self.changeReadStatus = function(newReadStatus) {
        var currentReadStatus = self.unreadCount() == 0 ? 1 : 0;
        if (currentReadStatus != newReadStatus) {
            $.post('/messaging/threads/changeReadStatus/', { threadId : self.id(), readStatus: newReadStatus }, function(response) {
                if (response.success) {
                    var newUnreadCount = newReadStatus == 0 ? 1 : 0;
                    self.unreadCount(newUnreadCount);
                    newReadStatus == 0 ? parent.newContactsCount(parent.newContactsCount() + 1) : parent.newContactsCount(parent.newContactsCount() - 1);
                }
            }, 'json');
        }
    }

    self.toggleHiddenStatus = function() {
        self.changeHiddenStatus(self.hidden() ? 0 : 1);
    }

    self.changeHiddenStatus = function(newHiddenStatus) {
        $.post('/messaging/threads/changeHiddenStatus/', { threadId : self.id(), hiddenStatus: newHiddenStatus }, function(response) {
            self.hidden(newHiddenStatus);
        }, 'json');
    }
	// Счётчик непрочитанных сообщений в диалоге
    self.inc = function() {
        self.unreadCount(self.unreadCount() + 1);
    }
	// Есть ли непрочитанные сообщения
    self.isRead = ko.computed(function() {
        return self.unreadCount() == 0;
    }, this);
	// Заголовки для кнопок
    self.hideButtonTitle = ko.computed(function() {
        return self.hidden() ? 'Показать диалог' : 'Скрыть диалог';
    }, this);
    self.readButtonTitle = ko.computed(function() {
        return self.isRead() ? 'Отметить как непрочитанное' : 'Отметить как прочитанное';
    }, this);
}
// Модель контакта (разве собеседник !== контакт???)
function Contact(data, parent) {
    var self = this;

    self.user = ko.observable(new User(data.user, parent));
    self.thread = ko.observable(data.thread == null? null : new Thread(data.thread, parent));
    self.draftText = '';
    self.draftImages = [];
}
// Модель изображения (Почему тут, разве не общая???)
function Image(data, parent) {
    var self = this;

    ko.mapping.fromJS(data, {}, self);
}
// Модель сообщения
function Message(data, parent) {
    var self = this;

    self.id = ko.observable(data.id);
    self.author_id = ko.observable(data.author_id);
    self.text = ko.observable(data.text);
    self.created = ko.observable(data.created);
    self.read = ko.observable(data.read);
    self.images = ko.observableArray(ko.utils.arrayMap(data.images, function(image) {
        return new Image(image, self);
    }));

    self.showAbuse = ko.observable(false);
    self.abuseReason = ko.observable(0);
    self.edited = ko.observable(false);
    self.deleted = ko.observable(false);
    self.isSpam = ko.observable(false);

    self.toggleShowAbuse = function() {
        self.showAbuse(! self.showAbuse());
    }

    self.markAsSpam = function() {
        self.isSpam(true);
        self.delete();
        self.toggleShowAbuse();
    }

    self.edit = function() {
        parent.redactor.set(self.text());
        parent.redactor.focus();

        parent.editingMessageId(self.id());
    }
	// Удаление сообщения
    self.delete = function() {
        $.post('/messaging/messages/delete/', { messageId : self.id() }, function(response) {
            if (response.success) {
                self.deleted(true);
            }
        }, 'json');
    }
	// Восстановление сообщения
    self.restore = function() {
        $.post('/messaging/messages/restore/', { messageId : self.id() }, function(response) {
            if (response.success)
                self.deleted(false);
        }, 'json');
    }
	// Модель пользователя из собеседника
    self.author = ko.computed(function() {
        return self.author_id() == parent.me.id() ? parent.me : parent.interlocutor().user();
    });
	// Подсветка непрочитанных
    self.highlighted = self.author_id() != parent.me.id() && ! self.read();
}
// ViewModel для всего модуля
function MessagingViewModel(data) {
    var self = this;
	// Счётчики
    self.newContactsCount = ko.observable(data.counters[0]);
    self.onlineContactsCount = ko.observable(data.counters[1]);
    self.friendsContactsCount = ko.observable(data.counters[2]);
	// Состояния
    self.editingMessageId = ko.observable(null);
    self.uploadedImages = ko.observableArray([]);
    self.tab = ko.observable(0);
    self.showHiddenContacts = ko.observable(false);
    self.clearSearchQuery = function() {
        self.searchQuery('');
    }
    self.searchQuery = ko.observable('');
	// Возможно одно и то же
		self.openContactInterlocutorId = ko.observable(null);
		self.interlocutor = ko.observable(null);
	// Контакты
    self.contacts = ko.observableArray(ko.utils.arrayMap(data.contacts, function(contact) {
        return new Contact(contact, self);
    }));
	// Сообщения
    self.messages = ko.observableArray([]);
	// Модель пользователя, от которого просматривается диалог
    self.me = new User(data.me, self);
	// Индикаторы процессов
    self.loadingMessages = ko.observable(false);
    self.loadingContacts = ko.observable(false);
    self.sendingMessage = ko.observable(false);
    self.interlocutorTyping = ko.observable(false);
    self.fullyLoaded = ko.observable(false);
	//
    self.typingTimer = null;
    self.meTyping = ko.observable(false);
    self.meTyping.subscribe(function(a) {
        $.post('/messaging/interlocutors/typing/', { typingStatus : a ? 1 : 0, interlocutorId : self.interlocutor().user().id() });
    });
	// Настройки отправки/переноса строки
    self.enterSetting = ko.observable(data.settings.messaging__enter);
    self.enterSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__enter', value : a ? 1 : 0 });
    });
	// Чёрный список
    self.blackListSetting = ko.observable(false);
    self.blackListSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__blackList', value : a ? 1 : 0 });
    });
	// Настройки звука
    self.soundSetting = ko.observable(data.settings.messaging__sound);
    self.soundSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__sound', value : a ? 1 : 0 });
    });
    self.toggleSoundSetting = function() {
        self.soundSetting(! self.soundSetting());
    }
	// ??? Расширенные настройки собеседника
    self.interlocutorExpandedSetting = ko.observable(data.settings.messaging__interlocutorExpanded);
    self.interlocutorExpandedSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__interlocutorExpanded', value : a ? 1 : 0 });
    });
    self.toggleinterlocutorExpandedSetting = function() {
        self.interlocutorExpandedSetting(! self.interlocutorExpandedSetting());
    }
	// Открытие диалога
    self.openThread = function(contact) {
		// Обновление состояний
        if (self.openContact() !== null) {
            self.openContact().draftText = self.redactor.get();
            self.openContact().draftImages = self.uploadedImages();
        }

        self.openContactInterlocutorId(contact.user().id());
        self.redactor.set(self.openContact().draftText);
        self.redactor.focus();
        self.uploadedImages(self.openContact().draftImages);

        self.interlocutorTyping(false);
        self.meTyping(false);
		// Получение данных о собеседнике (скорее всего уйдёт)
        $.get('/messaging/interlocutors/get/', { interlocutorId : contact.user().id() }, function(response) {
            self.interlocutor(new Interlocutor(response.interlocutor, self));
			// Получение списка сообщений
            if (self.openContact().thread() === null) {
                self.messages([]);
            }
            else {
                $.get('/messaging/threads/getMessages/', { threadId : contact.thread().id() }, function(response) {
                    self.openContact().thread().changeReadStatus(1);
                    self.messages(ko.utils.arrayMap(response.messages, function(message) {
                        return new Message(message, self);
                    }));
                    if (response.last)
                        self.fullyLoaded(true);
                }, 'json');
            }
        }, 'json');
    }
	// Работа с изображениями
    self.addImage = function(data) {
        self.uploadedImages.push(new Image(data));
    }

    self.removeImage = function(image) {
        self.uploadedImages.remove(image);
    }

    self.uploadedImagesIds = ko.computed(function() {
        return ko.utils.arrayMap(self.uploadedImages(), function(image) {
            return image.id();
        })
    });
	// Добавление в друзья (Имеет смысл вынести глобально???)
    self.addFriend = function()  {
        $.post('/friendRequests/send/', { to_id : self.interlocutor().user().id() }, function(response) {
            if (response.status)
                self.interlocutor().inviteSent(true);
        }, 'json');
    }
	// Открытый контакт (модель контакта)
    self.openContact = ko.computed(function() {
        return ko.utils.arrayFirst(self.contacts(), function(contact) {
            return contact.user().id() === self.openContactInterlocutorId();
        });
    }, this);
	// Редактируемое сообщение (модель сообщения)
    self.editingMessage = ko.computed(function() {
        return ko.utils.arrayFirst(self.messages(), function(message) {
            return message.id() === self.editingMessageId();
        });
    }, this);
	//
    self.contactsToShow = ko.computed(function() {
        var contacts = self.contacts().sort(function(l, r) {
            if (l.thread() !== null && r.thread() !== null)
                return l.thread().updated() == r.thread().updated() ? 0 : (l.thread().updated() > r.thread().updated() ? -1 : 1);

            if (l.thread() === null && r.thread() === null)
                return 0;

            if (l.thread() !== null && r.thread() === null)
                return -1;

            if (l.thread() === null && r.thread() !== null)
                return 1;
        });

        if (! self.showHiddenContacts())
            contacts = ko.utils.arrayFilter(contacts, function(contact) {
                return contact.thread() === null || ! contact.thread().hidden();
            });

        var query = self.searchQuery();
        if (query.length > 0)
            contacts = ko.utils.arrayFilter(contacts, function(contact) {
                return contact.user().fullName().toLowerCase().indexOf(query.toLowerCase()) != -1;
            });

        return contacts;
    });
	// Будет переписываться
    self.visibleContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return contact.thread() === null || ! contact.thread().hidden();
        });
    });
	//
    self.hiddenContactsToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.contactsToShow(), function(contact) {
            return contact.thread() !== null && contact.thread().hidden();
        });
    });
	//
    self.messagesToShow = ko.computed(function() {
        return self.messages().sort(function(l, r) {
            return l.id() == r.id() ? 0 : (l.id() > r.id() ? 1 : -1);
        });
    });
	// Начиная с какого сообщения загружать новые
    self.messagesOffset = ko.computed(function() {
        var result = 0;
        ko.utils.arrayForEach(self.messages(), function(message) {
            if (! message.deleted())
                result++;
        });
        return result;
    });
	// Сообщения собеседника (не используется???)
    self.interlocutorsMessagesToShow = ko.computed(function() {
        return ko.utils.arrayFilter(self.messagesToShow(), function(message) {
            return message.author().id() != self.me.id();
        });
    });
	// Последнее прочитанное сообщение (зачем???)
    self.lastReadMessage = ko.computed(function() {
        var result = null;
        ko.utils.arrayForEach(self.messagesToShow(), function(message) {
            if (message.read() && message.author().id() == self.me.id())
                result = message;
        });

        return result;
    });
	// Последнее не прочитанное сообщение (не используется???)
    self.lastUnreadMessage = ko.computed(function() {
        var result = null;
        ko.utils.arrayForEach(self.messagesToShow(), function(message) {
            if (! message.read() && message.author().id() == self.me.id())
                result = message;
        });

        return result;
    });
	// Изменение статуса (вкладки)
    self.changeTab = function(tab) {
        self.tab(tab);
        self.init();
    }
	// Найти модель собеседника по id
    self.findByInterlocutorId = function(interlocutorId) {
        return ko.utils.arrayFirst(self.contacts(), function(contact) {
            return contact.user().id() == interlocutorId;
        });
    }
	// Найти модель диалога по id
    self.findByThreadId = function(threadId) {
        return ko.utils.arrayFirst(self.contacts(), function(contact) {
            return contact.thread() !== null && contact.thread().id() == threadId;
        });
    }
	// Предзагрузка сообщений, установка позиций для прокрутки
    self.preload = function() {
        var startHeight = im.container.get(0).scrollHeight;
        var startTop = im.container.scrollTop();
        self.loadingMessages(true);
        $.get('/messaging/threads/getMessages/', { threadId : self.openContact().thread().id, offset: self.messagesOffset() }, function(response) {
           ko.utils.arrayForEach(response.messages, function(message) {
                self.messages.push(new Message(message, self));
            });
            self.loadingMessages(false);
            var endHeight = im.container.get(0).scrollHeight;
            im.container.scrollTop(endHeight - startHeight + startTop);
            if (response.last)
                self.fullyLoaded(true);
        }, 'json');
    }
	// Загрузка списка контактов
    self.loadContacts = function(callback, offset) {
        var data = {
            type : self.tab()
        };
        if (typeof offset !== "undefined")
            data.offset = offset;

        self.loadingContacts(true);
        $.get('/messaging/default/getContacts/', data, function(response) {
            callback(response);
            self.loadingContacts(false);
        }, 'json');
    }
	// Инициализация после открытия вкладки (Нет необходимости выносить отдельно???)
    self.init = function() {
        self.loadContacts(function(response) {
            self.contacts(ko.utils.arrayMap(response.contacts, function(contact) {
                return new Contact(contact, self);
            }));
            self.openThread(self.contactsToShow()[0]);
        });
    }
	// Перелистывание страницы контактов
    self.nextContactsPage = function() {
        self.loadContacts(function(response) {
            var newItems = ko.utils.arrayMap(response.contacts, function(contact) {
                return new Contact(contact, self);
            });

            self.contacts.push.apply(self.contacts, newItems);
        }, self.contacts().length);
    }
	// Отправка формы с сообщением
    self.submit = function() {
        if (self.editingMessageId() === null)
            self.sendMessage();
        else
            self.editMessage();
    }
	// Новое сообщение
    self.sendMessage = function() {
        self.sendingMessage(true);

        var data = {}
        data.interlocutorId = self.interlocutor().user().id();
        data.text = self.redactor.get();
        data.images = self.uploadedImagesIds();
        if (self.openContact().thread() !== null)
            data.threadId = self.openContact().thread().id();

        $.post('/messaging/messages/send/', data, function(response) {
            self.sendingMessage(false);
            self.meTyping(false);

            if (response.success) {
                self.redactor.set('');
                self.redactor.focus();
                self.uploadedImages([]);

                self.messages.push(new Message(response.message, self));

                if (self.openContact().thread() === null)
                    self.openContact().thread(new Thread(response.thread, self));
                else
                    self.openContact().thread().updated(response.time);
            } else if (response.error == 1) {
                self.interlocutor().isBlocked(true);
            }
        }, 'json');
    }
	// Редактирование сообщения
    self.editMessage = function() {
        var text = self.redactor.get();
        var data = {
            messageId : self.editingMessageId(),
            text : self.redactor.get()
        }

        $.post('/messaging/messages/edit/', data, function(response) {
            if (response.success) {
                self.editingMessage().text(text);
                self.editingMessage().edited(true);
                self.editingMessageId(null);
                self.redactor.set('');
                self.redactor.focus();
            }
        }, 'json');
    }
	// Отмена сообщения
    self.cancelMessage = function() {
        $.post('/messaging/messages/cancel/', { messageId : self.editingMessageId() }, function(response) {
            if (response.success) {
                self.messages.remove(self.editingMessage());
                self.editingMessageId(null);
                self.redactor.set('');
            }
        }, 'json');
    }
	// Установка фокуса в редактор
    self.focusEditor = function() {
        self.redactor.focus();
        return true;
    }
	// Переключение видимости контактов
    self.toggleShowHiddenContacts = function() {
        self.showHiddenContacts(! self.showHiddenContacts());
        im.hideContacts();
    }
	// Подсветка новых сообщний
    self.messageRendered = function(element, data) {
        if (data.highlighted)
            $(element).eq(1).addClass('im-message__new', 1500, function() {
                setTimeout(function() {
                    $(element).eq(1).removeClass('im-message__new', 1000);
                }, 2000);
            });
    };
	// Конструктор
    soundManager.setup({
        url: '/swf/',
        debugMode: false,
        onready: function() {
            soundManager.createSound({ id : 's', url : '/audio/1.mp3' });
        }
    });
    $(window).load(function() {
		// Инициализация редактора
        self.redactor = $('.redactor').redactorHG({
            minHeight: 17,
            autoresize: true,
            focus: true,
            toolbarExternal: '.redactor-control-b_toolbar',
            buttons: ['image', 'video', 'smile'],
            initCallback : function() {
                self.redactor = this;
                redactor = this;
                if (data.interlocutorId !== null || self.contactsToShow().length > 0)
                    self.openThread(data.interlocutorId == null ? self.contactsToShow()[0] : self.findByInterlocutorId(data.interlocutorId));
            },
            blurCallback : function() {
                if (self.openContact() !== null)
                    self.meTyping(false);
            },
            keyupCallback : function(e) {
                if (e.keyCode == 13 && self.enterSetting())
                    self.submit();
                else if (self.openContact() !== null) {
                    self.meTyping(true);
                    if (self.typingTimer !== null)
                        clearTimeout(self.typingTimer);
                    self.typingTimer = setTimeout(function() {
                        self.meTyping(false);
                    }, 5000);
                }
            },
            changeCallback: function(html)
            {
                im.messagesHeight();
                if((im.wrapper.height() - im.container.scrollTop()) < im.container.height() + 30) {
                    im.scrollBottom();
                }
            },
            comments: true
        });
		// Обработчики событий Comet-сервера
        Comet.prototype.receiveMessage = function (result, id) {
            var contact = self.findByInterlocutorId(result.contact.user.id);

            if (contact === null) {
                contact = new Contact(result.contact, self);
                self.contacts.push(contact);

                self.newContactsCount(self.newContactsCount() + 1);
                if (contact.user().online())
                    self.onlineContactsCount(self.onlineContactsCount() + 1);
            } else if (contact.thread() === null) {
                contact.thread(new Thread(result.contact.thread, self));

                self.newContactsCount(self.newContactsCount() + 1);
                if (contact.user().online())
                    self.onlineContactsCount(self.onlineContactsCount() + 1);
            } else {
                contact.thread().updated(result.time);

                if (contact.thread().unreadCount() == 0)
                    self.newContactsCount(self.newContactsCount() + 1);
            }

            contact.thread().inc();
            if (self.openContact().user().id() == contact.user().id()) {
                self.messages.push(new Message(result.message, self));
                self.openContact().thread().changeReadStatus(1);
            }

            if (self.soundSetting())
                soundManager.play('s');
        }

        Comet.prototype.typingStatus = function (result, id) {
            if (self.openContact().user().id() == result.interlocutorId)
                self.interlocutorTyping(result.typingStatus == 1);
        }

        Comet.prototype.readStatus = function (result, id) {
            if (self.openContact().thread() !== null && self.openContact().thread().id() == result.threadId) {
                ko.utils.arrayForEach(self.messagesToShow(), function(message) {
                    message.read(true);
                });
            }
        }
		// Добавление событий Comet-серверу
        comet.addEvent(2000, 'receiveMessage');
        comet.addEvent(2001, 'typingStatus');
        comet.addEvent(2002, 'readStatus');
    });
	// зачем ещё один обработчик???
    $(window).load(function() {
		// ??? почему именно $().load
        self.messages.subscribe(function() {
            if (! self.loadingMessages())
                im.container.imagesLoaded(function() {
                    im.scrollBottom();
                });
        });
		// прокрутка на нужное место
        im.container.scroll(function() {
            if (self.openContact() !== null && self.openContact().thread() !== null && self.loadingMessages() === false && self.fullyLoaded() === false && im.container.scrollTop() < 200)
                self.preload();
        });

        im.userList.scroll(function() {
            if (self.loadingContacts() === false && ((im.userList.scrollTop() + im.userList.height()) > (im.userList.prop('scrollHeight') - 200)))
                self.nextContactsPage();
        });
    });
}