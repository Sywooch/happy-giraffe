define('ko_messaging', ['knockout', 'ko_library', 'common', 'wysiwyg', 'comet', 'history2', 'soundmanager'], function(ko) {
    function MessagingImage(data, parent) {
        var self = this;

        ko.mapping.fromJS(data, {}, self);
    }
    
    MessagingUser.prototype = {
        objects: new Array(),
        binded: false,
        addObject: function(obj) {
            comet.addChannel(obj.channel);
            this.objects.push(obj);
        },
        bindEvents: function() {
            var self = this;
            if (!MessagingUser.prototype.binded) {
                MessagingUser.prototype.binded = true;
                // Обновление счётчика непрочитанных сообщений и даты последнего сообщения
                /*Comet.prototype.messagingContactsUpdateCount = function(result, id) {
                 ko.utils.arrayForEach(self.objects, function(obj) {
                 if (obj.id == result.user.id) {
                 obj.countNew(result.count);
                 obj.date(result.date);
                 // применить фильтр
                 }
                 });
                 }
                 comet.addEvent(2083, 'messagingContactsUpdateCount');*/
                // Мониторинг онлайна
                Comet.prototype.messagingUserOnline = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.user.id) {
                            obj.isOnline(result.user.online);
                            obj.lastOnline(result.user.lastOnline);
                            // Применить фильтр
                        }
                    });
                };
                comet.addEvent(3, 'messagingUserOnline');
                // Мониторинг изменений друзей и чёрного списка
                Comet.prototype.messagingUserFriends = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.user.id) {
                            obj.isFriend(result.user.isFriend);
                            obj.isBanned(result.user.isBanned);
                            // Применить фильтр
                        }
                    });
                };
                comet.addEvent(2073, 'messagingUserFriends');
                // Мониторинг события "пользователь набирает сообщение"
                Comet.prototype.messagingUserTyping = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.user.id) {
                            obj.setTyping();
                        }
                    });
                };
                comet.addEvent(2010, 'messagingUserTyping');
                Comet.prototype.blacklistAdded = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.blockedUserId) {
                            obj.blackListed(true);
                        }
                    });
                };
                comet.addEvent(3001, 'blacklistAdded');
                Comet.prototype.blacklistRemoved = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.blockedUserId) {
                            obj.blackListed(false);
                        }
                    });
                };
                comet.addEvent(3002, 'blacklistRemoved');
                Comet.prototype.requestSent = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.fromId) {
                            obj.hasOutgoingRequest(true);
                        }
                        if (obj.id == result.toId) {
                            obj.hasIncomingRequest(true);
                        }
                    });
                };
                comet.addEvent(4000, 'requestSent');
                Comet.prototype.friendAdded = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.user1Id || obj.id == result.user2Id) {
                            obj.isFriend(true);
                        }
                    });
                };
                comet.addEvent(4010, 'friendAdded');
                Comet.prototype.requestDeclined = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.fromId) {
                            obj.hasOutgoingRequest(false);
                        }
                        if (obj.id == result.toId) {
                            obj.hasIncomingRequest(false);
                        }
                    });
                };
                comet.addEvent(4001, 'requestDeclined');
                Comet.prototype.avatarUploaded = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.userId) {
                            obj.avatar(result.src.medium);
                        }
                    });
                };
                comet.addEvent(3003, 'avatarUploaded');
            }
        },
        // Применить фильтр к контактам
        // Фильтр - это метод, принимающий в качества аргумента модель пользователя
        // И возвращающий значение true/false, означающее показать/скрыть
        applyFilter: function(filter) {
            // Загрузить новые контакты, попадающие под этот фильтр
            // И скрыть лишние
            /*ko.utils.arrayForEach(self.objects, function(user) {
             user.isShow(this[filter](user));
             });*/
        }
    };

    function MessagingUser(viewModel, model) {
        var self = this;
        self.viewModel = viewModel;
        // Атрибуты модели пользователя
        self.id = model.id;
        self.profileUrl = model.profileUrl;
        self.messagingUrl = '/messaging?interlocutorId=' + model.id;
        self.firstName = model.firstName;
        self.lastName = model.lastName;
        self.fullName = function() {
            return self.firstName + ' ' + self.lastName;
        };
        self.gender = model.gender;
        self.avatar = ko.observable(model.avatar);
        self.channel = model.channel;
        // Состояния пользователя

        // Черный список
        self.blackListed = ko.observable(false);
        self.isShow = ko.computed(function() {
            return !self.blackListed();
        });
        self.isFriend = ko.observable(model.isFriend);
        self.isBanned = ko.observable(model.isBanned);
        self.isOnline = ko.observable(model.isOnline);
        self.lastOnline = ko.observable(model.lastOnline);
        self.typing = ko.observable(false);
        self.typingTimer = false;
        // Добавлен через поиск
        self.bySearching = ko.observable(!!model.bySearching);
        // Открыт сейчас
        self.isActive = ko.computed(function() {
            return self.viewModel && self.viewModel.currentThread() && self.viewModel.currentThread().user.id == self.id;
        });
        self.setTyping = function() {
            if (self.typingTimer)
                clearTimeout(self.typingTimer);
            self.typing(true); // сбрасывается через 5 секунд, если не пришло новое событие
            self.typingTimer = setTimeout(function() {
                self.typingTimer = false;
                self.typing(false);
            }, 5000);
        };
        // Количество новых сообщений
        self.countNew = ko.observable(model.count);
        // Дата последнего сообщения в диалоге
        self.date = ko.observable(model.date);
        // Друзья
        self.hasOutgoingRequest = ko.observable(model.hasOutgoingRequest);
        self.hasIncomingRequest = ko.observable(model.hasIncomingRequest);

        self.blackListHandler = function() {
            if (! self.blackListed())
                $.post('/ajax/blackList/', { userId : self.id });
            else
                $.post('/ajax/unBlackList/', { userId : self.id });
        }

        self.open = function() {
            MessagingThread.prototype.open(self);
        };

        self.addObject(self);
        self.bindEvents();
    }

    MessagingMessage.prototype = {
        objects: new Array(),
        binded: false,
        addObject: function(obj) {
            this.objects.push(obj);
        },
        bindEvents: function() {
            var self = this;
            if (!MessagingMessage.prototype.binded) {
                MessagingMessage.prototype.binded = true;
                // Обновление отметки о прочтении
                Comet.prototype.messagingMessageRead = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.message.id) {
                            // само сообщение прочитано
                            obj.dtimeRead(result.message.dtimeRead);
                        }
                    });
                };
                comet.addEvent(2011, 'messagingMessageRead');
                // Обновление сообщения
                Comet.prototype.messagingMessageUpdate = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.message.id) {
                            obj.text(result.message.text);
                        }
                    });
                };
                comet.addEvent(2021, 'messagingMessageUpdate');
                // Отмена сообщения
                Comet.prototype.messagingMessageCancelled = function(result, id) {
                    for (i in self.objects) {
                        var obj = self.objects[i];
                        if (obj.id == result.message.id && !obj.cancelled()) {
                            self.objects.splice(i, 1);
                            var threadMessages = obj.thread.messages();
                            for (j in threadMessages) {
                                var threadMessage = threadMessages[j];
                                if(threadMessage.id == result.message.id)
                                    obj.thread.messages.splice(j, 1);
                            }
                        }
                    }
                }
                comet.addEvent(2040, 'messagingMessageCancelled');
                // Удаление/восстановление сообщения
                Comet.prototype.messagingMessageDeleted = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.message.id) {
                            obj.dtimeDelete(result.message.dtimeDelete);
                        }
                    });
                }
                // Удаление
                comet.addEvent(2030, 'messagingMessageDeleted');
                // Восстановление
                comet.addEvent(2050, 'messagingMessageDeleted');
            }
        }
    };

    function MessagingMessage(model, thread) {
        var self = this;
        self.thread = thread;
        self.id = model.id;
        self.from = null;
        self.to = null;
        self.isMy = (self.thread.id == model.to_id);
        self.text = ko.observable(model.text);
        self.created = model.created;
        self.dtimeRead = ko.observable(model.dtimeRead);
        self.dtimeDelete = ko.observable(model.dtimeDelete);
        self.hidden = ko.observable(false);
        self.cancelled = ko.observable(false);
        //self.images = model.images;
        var timer = false;

        self.canEdit = ko.computed(function() {
            return self.isMy && !self.dtimeRead();
        });
        self.canCancel = ko.computed(function() {
            return self.isMy && !self.dtimeRead();
        });
        self.canDelete = ko.computed(function() {
            return !self.isMy || self.dtimeRead();
        });

        self.isStick = function(messages, index) {
            var prevMessage = messages[index - 1];
            var curMessage = messages[index];
            return prevMessage && prevMessage.from == curMessage.from;
        };

        /**
         * Удаление сообщения
         */
        self.deleteMessage = function() {
            // Просто отправим запрос, ответ придёт событием
            $.post('/messaging/messages/delete/', {messageId: self.id});
        };
        /**
         * Отмена сообщения
         */
        self.cancelMessage = function() {
            self.cancelled(true);
            $.post('/messaging/messages/cancel/', {messageId: self.id});
        };
        /**
         * Восстановление сообщения
         */
        self.restore = function() {
            // Просто отправим запрос, ответ придёт событием
            $.post('/messaging/messages/restore/', {messageId: self.id});
        };

        self.beginEditing = function() {
            self.thread.beginEditing(self);
        };

        self.markAsReaded = function() {
            $.post('/messaging/messages/readed/', {messageId: self.id});
        }

        self.show = function() {
            if(!self.dtimeRead() && !timer && self.to.id == Messaging.prototype.currentThread().me.id) {
                timer = setTimeout(function() {
                    self.markAsReaded();
                }, 1000);
            }
        };
        self.hide = function() {
            if(!self.dtimeRead()) {
                clearInterval(timer);
                timer = false;
            }
        };

        self.reported = ko.observable(false);
        self.report = function() {
            $.post('/ajax/report/', { entity : 'MessagingMessage', entity_id : self.id }, function() {
                self.reported(true);
            }, 'json');
        }

        // Текст конструктора
        ko.utils.arrayForEach(MessagingUser.prototype.objects, function(user) {
            if (user.id == model.from_id)
                self.from = user;
            if (user.id == model.to_id)
                self.to = user;
        });

        self.addObject(self);
        self.bindEvents();
    }

    MessagingThread.prototype = {
        objects: new Array(),
        binded: false,
        addObject: function(obj) {
            this.objects.push(obj);
        },
        bindEvents: function() {
            var self = this;
            if (!MessagingThread.prototype.binded) {
                MessagingThread.prototype.binded = true;
                // Добавление сообщения
                Comet.prototype.messagingMessageAdded = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.dialog.id) {
                            var message = new MessagingMessage(result.message, obj);
                            // Добавим сообщение в диалог
                            if(obj.scrollManager.scrollBot <= 40) {
                                obj.scrollManager.setFix('bot');
                            } else {
                                obj.scrollManager.setFix('top');
                            }
                            obj.messages.push(message);
                            obj.scrollManager.setFix();
                            // Обновим дату контакта и счётчик
                            obj.user.date(message.created);
                            // Прокрутим к новому сообщению
                            //obj.scrollManager.scrollTo(message);
                        }
                    });
                };
                comet.addEvent(2020, 'messagingMessageAdded');
                // Удаление диалога
                Comet.prototype.messagingThreadDeleted = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.dialog.id) {
                            obj.deletedDialogs.push(result.dialog.dtimeDelete);
                            ko.utils.arrayForEach(obj.messages(), function(message) {
                                // Скрываем сообщения, которые были написаны до момента удаления диалога
                                if(message.created < result.dialog.dtimeDelete) {
                                    message.hidden(true);
                                }
                            });
                        }
                    });
                };
                comet.addEvent(2060, 'messagingThreadDeleted');
                // Восстановление диалога
                Comet.prototype.messagingThreadRestored = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.dialog.id) {
                            obj.deletedDialogs([]);
                            ko.utils.arrayForEach(obj.messages(), function(message) {
                                message.hidden(false);
                            });
                        }
                    });
                };
                comet.addEvent(2070, 'messagingThreadRestored');
                // Сообщение прочитано, и если оно редактировалось, то отменить редактирование
                Comet.prototype.messagingThreadMessageRead = function(result, id) {
                    ko.utils.arrayForEach(self.objects, function(obj) {
                        if (obj.id == result.dialog.id && obj.editingMessage() && obj.editingMessage().id == result.message.id) {
                            obj.cancelEditing();
                        }
                    });
                };
                comet.addEvent(2011, 'messagingThreadMessageRead');
            }
        },
        open: function(user) {
            var thread = ko.utils.arrayFirst(this.objects, function(obj) {
                return obj.user.id == user.id;
            });
            if(thread != Messaging.prototype.currentThread()) {
                if (!thread) {
                    thread = new MessagingThread(user.viewModel.me, user);
                } else {
                    thread.beforeOpen();
                }
                window.document.title = 'Диалоги: ' + user.fullName();
                History.pushState(null, window.document.title, '?interlocutorId=' + user.id);
                thread.scrollManager.setFix('bot');
                Messaging.prototype.currentThread(thread);
                thread.scrollManager.setFix();
            }
        }
    };

    function MessagingThread(me, user) {
        var self = this;
        self.scrollManager = ko.bindingHandlers.fixScroll.getNewManager();
        self.id = user.id;
        self.me = me;
        self.user = user;
        self.messages = ko.observableArray([]);
        // Текст нового сообщения
        self.editor = ko.observable('');
        // Таймер для отправки события "набирает сообщение"
        self.typingTimer = false;
        // Изображения
        self.uploadedImages = ko.observableArray([]);

        // состояния
        self.sendingMessage = ko.observable(false);
        self.sendingMessageError = ko.observable(false);
        self.loadingMessages = ko.observable(false);
        self.fullyLoaded = ko.observable(false);
        self.editing = ko.observable(false);
        self.editingMessage = ko.observable(false);
        self.deletedDialogs = ko.observableArray([]);

        // Переключение диалога
        self.beforeOpen = function() {
            // почистить список от удалённых сообщений
            self.messages.remove(function(message) {
                return !!message.dtimeDelete() || message.cancelled();
            });
            self.deletedDialogs([]);
        };

        // Конфигурация редактора
        self.editorConfig = {
            minHeight: 17,
            plugins: ['imageCustom', 'smilesModal', 'videoModal'],
            newStyle: true,
            callbacks: {
                init : [
                    function() {
                        im.renew();
                    }
                ],
                change : [
                    function() {
                        setTimeout(function() {
                            im.renew();
                            self.scrollManager.setFix();
                        }, 0);
                    }
                ],
                keydown : [
                    function(e) {
                        if (e.keyCode == 13 && me.viewModel.settings.messaging__enter() != e.ctrlKey) {
                            self.sendMessage();
                            e.preventDefault();
                        } else {
                            self.typing();
                        }
                        self.scrollManager.setFix('bot');
                    }
                ]
            }
        };

        self.lastReadMessage = ko.computed(function() {
            var result = null;
            ko.utils.arrayForEach(self.messages(), function(message) {
                if (message.dtimeRead() && message.isMy)
                    result = message;
            });

            return result;
        });

        self.firstUnreadMessage = ko.computed(function() {
            return ko.utils.arrayFirst(self.messages(), function(message) {
                return !message.dtimeRead() && !message.isMy;
            });
        });

        // методы
        self.setEditing = function() {
            self.editing(true);
        }
        self.beginEditing = function(message) {
            self.editingMessage(message);
            self.editor(message.text());
            self.setEditing();
        };
        self.cancelEditing = function() {
            self.editingMessage(false);
            self.editor('');
            self.editing(false);
        }
        self.deleteDialog = function() {
            // Просто отправим запрос, ответ придёт событием
            $.post('/messaging/threads/delete/', {userId: self.id});
        };
        self.restoreDialog = function() {
            // Просто отправим запрос, ответ придёт событием
            $.post('/messaging/threads/restore/', {userId: self.id, restore: self.deletedDialogs()});
        };
        self.sendMessage = function() {
            self.sendingMessage(true);
            self.sendingMessageError(false);
            var data = {};

            data.text = self.editor();
            //data.images = self.uploadedImagesIds();

            var message = self.editingMessage();
            if(message) {
                data.messageId = message.id;
                $.post('/messaging/messages/edit/', data, function(response) {
                    self.sendingMessage(false);

                    if (response.success) {
                        self.editor('');
                        self.uploadedImages([]);
                    } else {
                        //
                    }
                    self.editingMessage(false);
                }, 'json');
            } else {
                data.interlocutorId = self.id;
                $.ajax({
                    url: '/messaging/messages/send/',
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        self.sendingMessage(false);

                        if (response.success) {
                            self.editor('');
                            self.uploadedImages([]);
                        } else {
                            self.sendingMessageError(true);
                        }
                    },
                    error: function() {
                        self.sendingMessage(false);
                        self.sendingMessageError(true);
                    }
                });
            }
        }
        self.addImage = function(data) {
            self.uploadedImages.push(new MessagingImage(data));
        }

        self.removeImage = function(image) {
            self.uploadedImages.remove(image);
        }

        self.uploadedImagesIds = ko.computed(function() {
            return ko.utils.arrayMap(self.uploadedImages(), function(image) {
                return image.id();
            })
        });
        /**
         * Набор символа
         */
        self.typing = function() {
            if (self.typingTimer === false) {
                self.sendTyping(); // отправка события раз в 3 секунды
                self.typingTimer = setTimeout(function() {
                    self.typingTimer = false;
                }, 3000);
            }
        }
        /**
         * Отправка события "набирает сообщение"
         */
        self.sendTyping = function() {
            $.post('/messaging/interlocutors/typing/', {typingStatus: 1, interlocutorId: self.user.id});
        }

        /**
         * Загрузка сообщений
         */
        self.loadMessages = function() {
            if(!self.fullyLoaded() && !self.loadingMessages()) {
                self.loadingMessages(true);
                var data = {userId: self.user.id};
                var isFirst = self.messages().length == 0;
                if(self.messages().length > 0) {
                    data.lastDate = self.messages()[0].created;
                }

                $.get('/messaging/threads/getMessages/', data, function(response) {
                    response.messages = response.messages.reverse();

                    self.scrollManager.setFix('bot');
                    self.messages(ko.utils.arrayMap(response.messages, function(message) {
                        return new MessagingMessage(message, self);
                    }).concat(self.messages()));
                    self.loadingMessages(false);
                    // таймер - это костыль, т.к. иначе передёргивает. Причину не нашёл.
                    setTimeout(function() {
                        self.scrollManager.setFix();
                        // Выставим скролл
                        if (isFirst) { // если первая загрузка
                            var firstUnread = self.firstUnreadMessage();
                            if (firstUnread) {
                                self.scrollManager.scrollTo(firstUnread);
                            }
                        }
                    }, 100);

                    if (response.last)
                        self.fullyLoaded(true);
                }, 'json');
            }
        };

        // Текст конструктора
        self.addObject(self);
        self.bindEvents();
        self.loadMessages();
    }

    Messaging.prototype = {
        currentThread: ko.observable(false),
    }

    function Messaging(model) {
        var self = this;
        self.threads = ko.observableArray([]);
        self.me = null;
        self.countTotal = ko.observable(model.counters.total);
        self.loadindContacts = ko.observable(false);
        self.savedFilter = ko.observable(0);
        self.currentFilter = ko.observable(0);
        self.settings = new MessagingSettings(model.settings);
        self.search = ko.observable('');
        self.loadedAllContacts = [
            false,
            false,
            false,
            false,
            true
        ];
        self.search.subscribe(function() {
            self.loadedAllContacts[4] = false;
        });

        var filters = [
            function(user) {
                // Данную функциональность выполнит MessagingUser.isShow
                //return ! user.blackListed();
            },
            function(user) {
                return user.countNew() > 0;
            },
            function(user) {
                return user.isOnline();
            },
            function(user) {
                return user.isFriend() && user.isOnline();
            },
            function(user) {
                // тут поиск
                return false;
            }
        ];

        // Карта соответсвия id пользователя из контактов, его номеру в MessagingUsers.prototype.objects
        // т.к. в MessagingUsers.prototype.objects пользователи только добавляются, то номерация не собьётся
        self.usersMap = {};

        /**
         * Функция добавляет пользователя в списко контактов,
         * и возвращает модель пользователя, если он добавлен, и
         * false, если он был найден
         *
         * @param {type} data
         * @returns {undefined}
         */
        function addContact(data) {
            var user = false;
            if(user = getContactById(data.id)) {
                // Значит пользователь уже есть в контактах
                if(user.bySearching() && !data.bySearching) {
                    // Если имеющийся пользователь найден через поиск,
                    // а запрашиваемый пользователь найден не через поиск,
                    // то обновим флаг.
                    user.bySearching(false);
                }
                return false;
            } else {
                // Пользователя ещё нет в контактах
                user = new MessagingUser(self, data);
                self.usersMap[data.id] = MessagingUser.prototype.objects.length - 1;
                user.date.subscribe(function(val) {
                    if(val) {
                        self.sortContacts();
                    }
                });
                return user;
            }
        }

        /**
         * Функция вернёт модель пользователя с указанным id,
         * если такого пользователя нет в списке контактов,
         * то будет возвращено false
         *
         * @param {int} id
         * @returns {MessagingUser | false}
         */
        function getContactById(id) {
            var user = false;
            if(self.usersMap[id] !== undefined) {
                user = MessagingUser.prototype.objects[self.usersMap[id]];
            }
            return user;
        }

        self.setFilter = function(type) {
            self.currentFilter(type);
            self.search('');
        };

        self.sortContacts = function() {
            // отсортируем по свежести
            self.users[0].sort(function(user1, user2) {
                return user1.date() < user2.date() ? 1 : (user1.date() == user2.date() ? 0 : -1);
            });
        };

        self.users = [
            ko.observableArray([]),
            false,
            false,
            false,
            false,
        ];

        self.users[1] = ko.computed(function() {
            return ko.utils.arrayFilter(self.users[0](), function(user) {
                return filters[1](user);
            });
        });

        self.users[2] = ko.computed(function() {
            return ko.utils.arrayFilter(self.users[0](), function(user) {
                return filters[2](user);
            });
        });

        self.users[3] = ko.computed(function() {
            return ko.utils.arrayFilter(self.users[0](), function(user) {
                return filters[3](user);
            });
        });

        self.users[4] = ko.computed(function() {
            if(self.search().length > 0) {
                if(self.currentFilter() !== 4) {
                    self.savedFilter(self.currentFilter());
                    self.currentFilter(4);
                }
                var search = self.search().split(' ', 2);
                var regexp;
                var error = false;
                try {
                    if(search.length == 1) {
                        regexp = new RegExp("(^" + search[0] + ")|(^\\S+\\s" + search[0] + ")", 'i');
                    } else {
                        regexp = new RegExp("(^" + search[0] + "\\S*\\s" + search[1] + ")|(^" + search[1] + "\\S*\\s" + search[0] + ")", 'i');
                    }
                } catch(e) {
                    error = true;
                }

                return error ? [] : ko.utils.arrayFilter(self.users[0](), function(user) {
                    return user.fullName().match(regexp);
                });
            } else {
                self.currentFilter(self.savedFilter());

                return [];
            }
        });

        self.clearSearch = function() {
            self.search('');
        };

        self.getContactList = ko.computed(function() {
            //console.log(self.users[self.currentFilter()]());
            return self.users[self.currentFilter()]();
        });

        self.loadContacts = function() {
            // Если загрузка не в процессе, и контакты загружены не полностью, то загружаем
            var type = self.currentFilter();
            if(!self.loadindContacts() && !self.loadedAllContacts[type]) {
                self.loadindContacts(true);
                var url = '/messaging/default/getContacts/';
                var data = { offset: 0 };
                if(type == 4) {
                    url = '/messaging/default/search/';
                    data.search = self.search();
                    // Такой сдвиг покроет большинство случаев.
                    // Выявить неправильное поведение можно только
                    // при совсем искусственных тестах
                    data.offset = Math.max(0, self.users[type]().length - 20);
                } else {
                    data.type = type
                    ko.utils.arrayForEach(self.users[type](), function(user) {
                        if(!user.bySearching())
                            data.offset ++;
                    });
                }
                $.get(url, data, function(response) {
                    var contacts = ko.utils.arrayMap(response.contacts, function(user) {
                        if(type == 4) {
                            user.bySearching = true;
                        }
                        return addContact(user);
                    });
                    // отфильтруем уже имеющиеся контакты
                    contacts = ko.utils.arrayFilter(contacts, function(user) {
                        return !!user;
                    });
                    self.users[0].push.apply(self.users[0], contacts);
                    self.loadindContacts(false);

                    //Поставим флажок о полной загрузки контактов
                    if(response.contacts.length < 50) {
                        self.loadedAllContacts[type] = true;
                    }
                }, 'json');
            }
        };
        // Текст конструктора

        // Прочитано сообщение
        Comet.prototype.messagingReadMessage = function(result, id) {
            if(result.message.to_id == self.me.id) {
                // Если прочитанное сообщение предназначалось нам, то уменьшим счётчики
                var user = ko.utils.arrayFirst(self.users[0](), function(user) {
                    return user.id == result.dialog.id;
                });
                if(user) {
                    user.countNew(Math.max(0, user.countNew() - 1));
                }
                self.countTotal(Math.max(0, self.countTotal() - 1));
            }
        };
        comet.addEvent(2011, 'messagingReadMessage');

        // Добавлено новое сообщение
        Comet.prototype.messagingNewMessage = function(result, id) {
            var user = getContactById(result.dialog.id);
            if(!user) {
                // Нет загруженного пользователя, запросим с сервера
                $.get('/messaging/default/getUserInfo/', { id: result.dialog.id }, function(data) {
                    // и добавим в список
                    user = addContact(data);
                    self.users[0].push(user);
                    self.sortContacts();
                    if(result.message.to_id == self.me.id) {
                        self.countTotal(self.countTotal() + 1);
                    }
                }, 'json');
            } else {
                // Нашли его в нашем списке, если сообщение нам, то обновим счётчики и пиликнем
                if(result.message.to_id == self.me.id) {
                    user.countNew(user.countNew() + 1);
                    user.date(result.message.dtimeRead);
                    self.countTotal(self.countTotal() + 1);
                    if (self.settings.messaging__sound())
                        soundManager.play('s');
                }
            }

        };
        comet.addEvent(2020, 'messagingNewMessage');

    // сейчас сам должен переместиться.
        /*	// Онлайн/оффлайн пользователя
         Comet.prototype.messagingOnline = function(result, id) {
         var user = ko.utils.arrayFirst(self.users[0](), function(user) {
         return user.id == result.dialog.id;
         });
         user.isOnline(1);
         };
         comet.addEvent(3, 'messagingOnline');*/

        /** @todo Тут событие манипуляции с друзьями */
        /*Comet.prototype.messagingFriendChanges = function(result, id) {
         // обновить счётчики
         // переместить контакт
         };
         comet.addEvent(3, 'messagingFriendChanges');*/

        soundManager.setup({
            url: '/swf/',
            debugMode: false,
            onready: function() {
                soundManager.createSound({ id : 's', url : '/audio/1.mp3' });
            }
        });

        self.users[0](ko.utils.arrayMap(model.contacts, function(user) {
            // Должны добавиться все, т.к. список контактов пустой
            return addContact(user);
        }));
        self.me = new MessagingUser(self, model.me);

        function parseUrl() {
            var params = /(\?|&)interlocutorId=(\d+)/.exec(window.location.search);
            if(params && params[2]) {
                var id = params[2];
                var user = getContactById(id);
                if(!user) {
                    // Нет загруженного пользователя, запросим с сервера
                    $.get('/messaging/default/getUserInfo/', { id: id }, function(data) {
                        user = addContact(data);
                        user.open();
                    }, 'json');
                } else {
                    user.open();
                }
                return true;
            }
            return false;
        }
        History.Adapter.bind(window, 'statechange', function() { // Note: We are using statechange instead of popstate
            parseUrl();
        });
        if(!parseUrl() && self.users[0]()[0]) {
            self.users[0]()[0].open();
        }
    }

    function MessagingSettings(data)
    {
        var self = this;

        $.each(data, function(key, item) {
            self[key] = ko.observable(item);
        });

        self.toggle = function(key) {
            var observable = self[key];
            self.update(key, ! observable());
        }

        self.update = function(key, value) {
            $.post('/ajax/setUserAttribute/', { key : key, value : value });
        }
 
        Comet.prototype.settingChanged = function(result, id) {
            self[result.key](result.value);
        }
        comet.addEvent(3000, 'settingChanged');
    }

    window.MessagingUser = MessagingUser;
    window.MessagingSettings = MessagingSettings;
    
    return Messaging;
});
