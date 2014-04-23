/*
 * Редактирование сообщения
 * Событие о прочтении
 * Дружба из интерфейса (отправить запрос, подтвердить запрос, отклонить запрос)
 * Сообщения о дружбе в плашке
 * Добавление в чёрный список и друзья (сложные отношения)
 * Применение фильтров к списку друзей + догрузка
 * При поиске необходимо убрать выделения с других вкладок, после закрытия поиска необходимо вернуться на вкладку до поиска
 * Счётчик сообщений только на новых
 * Открытие диалога по-умолчанию??
 * требование о загрузки фотографии - отмена в реалтайме?
 * Эксперементы с полностью загруженным спиком контактов, но частичным отображением
 */
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
    self.FRIENDS_STATE_FRIENDS = 0;
    self.FRIENDS_STATE_OUTGOING = 1;
    self.FRIENDS_STATE_INCOMING = 2;
    self.FRIENDS_STATE_NOTHING = 3;
	self.viewModel = viewModel;
	// Атрибуты модели пользователя
	self.id = model.id;
    self.profileUrl = model.profileUrl;
	self.firstName = model.firstName;
	self.lastName = model.lastName;
	self.fullName = function() {
		return self.firstName + ' ' + self.lastName;
	};
	self.gender = model.gender;
	self.avatar = ko.observable(model.avatar);
	self.channel = model.channel;
    // Пустой ли диалог. Может быть пустым при загрузке отдельного пользователя.
    // Может стать пустым при удалении диалога или всех сообщений из него.
    self.emptyDialog = ko.observable(!model.date);
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

    self.friendsState = ko.computed(function() {
        if (self.isFriend())
            return self.FRIENDS_STATE_FRIENDS;
        if (self.hasIncomingRequest())
            return self.FRIENDS_STATE_INCOMING;
        if (self.hasOutgoingRequest())
            return self.FRIENDS_STATE_OUTGOING;
        return self.FRIENDS_STATE_NOTHING;
    })

    self.blackListHandler = function() {
        if (! self.blackListed())
            $.post('/ajax/blackList/', { userId : self.id });
        else
            $.post('/ajax/unBlackList/', { userId : self.id });
    }

    self.friendsInvite = function() {
        $.post('/friendRequests/send/', { to_id : self.id });
    }

    self.friendsAccept = function() {
        $.post('/friends/requests/accept/', { fromId : self.id });
    }

    self.friendsDecline = function() {
        $.post('/friends/requests/decline/', { fromId : self.id });
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
                        // поставим отметку, что диалог теперь пуст
                        obj.user.emptyDialog(true);
                        obj.scrollManager.setFix('bot');
						obj.deletedDialogs.push(result.dialog.dtimeDelete);
						ko.utils.arrayForEach(obj.messages(), function(message) {
							// Скрываем сообщения, которые были написаны до момента удаления диалога
							if(message.created < result.dialog.dtimeDelete) {
								message.hidden(true);
							}
						});
                        obj.scrollManager.setFix();
				}
				});
			};
			comet.addEvent(2060, 'messagingThreadDeleted');
			// Восстановление диалога
			Comet.prototype.messagingThreadRestored = function(result, id) {
				ko.utils.arrayForEach(self.objects, function(obj) {
					if (obj.id == result.dialog.id) {
                        // поставим отметку, что диалог теперь не пуст
                        obj.user.emptyDialog(false);
                        obj.scrollManager.setFix('bot');
						obj.deletedDialogs([]);
						ko.utils.arrayForEach(obj.messages(), function(message) {
							message.hidden(false);
						});
                        obj.scrollManager.setFix();
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
        History.pushState(null, window.document.title, '?interlocutorId=' + user.id);
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
            init: [
                function() {
                    im.renew();
                }
            ],
            change: [
                function() {
                    setTimeout(function() {
                        im.renew();
                        self.scrollManager.setFix();
                    }, 0);
                }
            ],
            keydown: [
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

function ContactsManager(viewModel, model) {
    var self = this;
    self.viewModel = viewModel;
    self.openedUser = ko.observable(false);
    self.currentFilter = ko.observable(0);
    
	self.countTotal = ko.observable(model.counters.total);
	self.loadindContacts = ko.observable(false);
	self.loadedAllContacts = [
		false,
		false,
		false,
		false,
		false
	];

    
    self.setFilter = function(val) {
        self.currentFilter(val);
    };
    
    // Поиск
    self.search = ko.observable('');
    self.searchRegExp = ko.observable(false);
    self.savedFilter = false;
    self.clearSearch = function() {
        self.search('');
    };
    // Преобразование строки поиска в регулярку
    self.search.subscribe(function(val) {
        if(val.length > 0) {
            if(self.savedFilter === false) {
                self.savedFilter = self.currentFilter();
                self.currentFilter(4);
            }
            var search = val.split(' ', 2);
            try {
                if(search.length == 1) {
                    self.searchRegExp(new RegExp("(^" + search[0] + ")|(^\\S+\\s" + search[0] + ")", 'i'));
                } else {
                    self.searchRegExp(new RegExp("(^" + search[0] + "\\S*\\s" + search[1] + ")|(^" + search[1] + "\\S*\\s" + search[0] + ")", 'i'));
                }
                self.loadedAllContacts[4] = false;
            } catch(e) {
                self.searchRegExp(false);
            }
        } else {
            self.currentFilter(self.savedFilter);
            self.savedFilter = false;
            self.searchRegExp(false);
        }
    });
    
    // Список контактов
    self.users = ko.observableArray([]);
    // Сортировка списка контактов
    self.sort = function() {
		self.users.sort(function(user1, user2) {
            // Если user1 является открытым
            if(user1 === self.openedUser())
                return -1;
            // Если user2 является открытым
            if(user2 === self.openedUser())
                return 1;
			return user1.date() < user2.date() ? 1 : (user1.date() === user2.date() ? 0 : -1);
		});
    };
    
    // Фильтры
    self.filters = [
		function(user) {
            // не пустой диалог, или это открытый пользователь
            return !user.emptyDialog() || user == self.openedUser();
		},
		function(user) {
            // с новыми сообщениями
			return user.countNew() > 0;
		},
		function(user) {
            // пользователи онлайн c не пустыми диалогами или открытый пользователь онлайн
			return (!user.emptyDialog() || user == self.openedUser()) && user.isOnline();
		},
		function(user) {
            // друзья онлайн
			return (!user.emptyDialog() || user == self.openedUser()) && user.isFriend() && user.isOnline();
		},
		function(user) {
            // поиск
            return self.searchRegExp() === false ? false : user.fullName().match(self.searchRegExp());
		}
    ];
    
    self.getOffset = function() {
        var offset = 0;
        ko.utils.arrayForEach(self.users(), function(user) {
            // Считаем пользователей, найденных не через поиск и проходящих по фильтру
            // не используем self.filtered, т.к. там может оказаться больше пользователей,
            // из-за того что они от туда не удаляются.
            if (!user.bySearching() && self.filters[self.currentFilter()](user))
                offset++;
        });
        return offset;
    };
    
    // Подпишемся на изменение вкладки
    self.currentFilter.subscribe(function() {
        ko.utils.arrayForEach(self.users(), function(user) {
            // скидываем флажки
            user.showed = false;
        });
    });
    
    // Отфильтрованные пользователи
    self.filtered = ko.computed(function() {
        // !если поиск, то могут исчезать!
        return ko.utils.arrayFilter(self.users(), function(user) {
            if(self.currentFilter() == 4) {
                // Поиск
                self.searchRegExp(); // для зависимости от поисковой фразы
                return self.filters[4](user);
            } else {
                // Обычный режим работы
                user.showed = user.showed || self.filters[self.currentFilter()](user);
                return user.showed;
            }
        });
    });
    
	// Карта соответсвия id пользователя из контактов, его номеру в MessagingUsers.prototype.objects
	// т.к. в MessagingUsers.prototype.objects пользователи только добавляются, то номерация не собьётся
	self.usersMap = {};
	
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
			user = new MessagingUser(self.viewModel, data);
            self.users.push(user);
			self.usersMap[data.id] = MessagingUser.prototype.objects.length - 1;
			return user;
		}
	}
    
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
				data.offset = Math.max(0, self.filtered().length - 20);
			} else {
				data.type = type
                data.offset = self.getOffset();
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
				self.users.push.apply(self.users, contacts);
				self.loadindContacts(false);
				
				//Поставим флажок о полной загрузки контактов
				if(response.contacts.length < 50) {
					self.loadedAllContacts[type] = true;
				}
			}, 'json');
		}
	};
    
    function parseUrl(open) {
        var params = /(\?|&)interlocutorId=(\d+)/.exec(window.location.search);
        if(params && params[2]) {
            var id = params[2];
            var user = getContactById(id);
            if(!user) {
                // Нет загруженного пользователя, запросим с сервера
                $.get('/messaging/default/getUserInfo/', { id: id }, function(data) {
                    user = addContact(data);
                    self.open(user);
                    if(open)
                        self.openedUser(user);
                }, 'json');
            } else {
                self.open(user);
                if(open)
                    self.openedUser(user);
            }
            return true;
        }
        return false;
    }
    
    self.users(ko.utils.arrayMap(model.contacts, function(user) {
        // Должны добавиться все, т.к. список контактов пустой
        return addContact(user);
    }));
    
    History.Adapter.bind(window, 'statechange', function() {
        parseUrl(false);
    });
    
    self.open = function(user) {
        var thread = ko.utils.arrayFirst(MessagingThread.prototype.objects, function(obj) {
            return obj.user.id == user.id;
        });
        if (thread != Messaging.prototype.currentThread()) {
            if (!thread) {
                thread = new MessagingThread(user.viewModel.me, user);
            } else {
                thread.beforeOpen();
            }
            window.document.title = 'Диалоги: ' + user.fullName();
            thread.scrollManager.setFix('bot');
            Messaging.prototype.currentThread(thread);
            thread.scrollManager.setFix();
        }
    }

    if (!parseUrl(true) && self.users()[0]) {
        self.users()[0].open();
    }

    ko.computed(function() {
        self.openedUser();
        self.users();
        self.sort();
    });

    // Прочитано сообщение
    Comet.prototype.messagingReadMessage = function(result, id) {
        if (result.message.to_id == self.viewModel.me.id) {
            // Если прочитанное сообщение предназначалось нам, то уменьшим счётчики
            var user = ko.utils.arrayFirst(self.users(), function(user) {
                return user.id == result.dialog.id;
            });
            if (user) {
                user.countNew(Math.max(0, user.countNew() - 1));
            }
            self.countTotal(Math.max(0, self.countTotal() - 1));
        }
    };
    comet.addEvent(2011, 'messagingReadMessage');

    // Добавлено новое сообщение
    Comet.prototype.messagingNewMessage = function(result, id) {
        var user = getContactById(result.dialog.id);
        if (!user) {
            // Нет загруженного пользователя, запросим с сервера
            $.get('/messaging/default/getUserInfo/', {id: result.dialog.id}, function(data) {
                // и добавим в список
                user = addContact(data);
                //self.sortContacts();
                if (result.message.to_id == self.viewModel.me.id) {
                    self.countTotal(self.countTotal() + 1);
                }
            }, 'json');
        } else {
            // Поставим флаг, что диалог не пустой
            user.emptyDialog(false);
            // Нашли его в нашем списке, если сообщение нам, то обновим счётчики и пиликнем
            if (result.message.to_id == self.viewModel.me.id) {
                user.countNew(user.countNew() + 1);
                user.date(result.message.created);
                self.countTotal(self.countTotal() + 1);
                if (self.viewModel.settings.messaging__sound())
                    soundManager.play('s');
            }
        }

    };
    comet.addEvent(2020, 'messagingNewMessage');
    
    Comet.prototype.messagingContactsManagerMessageCancelled = function(result) {
        var user = getContactById(result.dialog.id);
        if(user && result.message.to_id == self.viewModel.me.id) {
            user.countNew(Math.max(0, user.countNew()-1));
            self.countTotal(Math.max(0, self.countTotal()-1));
        }
    }
    comet.addEvent(2040, 'messagingContactsManagerMessageCancelled');

}

Messaging.prototype = {
    currentThread: ko.observable(false)
}

function Messaging(model) {
	var self = this;
	self.threads = ko.observableArray([]);
	self.me = new MessagingUser(self, model.me);
    self.contactsManager = new ContactsManager(self, model);
    self.settings = new MessagingSettings(model.settings);
    
    self.notConfirmDelete = ko.observable(false);
	
	self.getContactList = self.contactsManager.filtered;
	
	// Текст конструктора

    Comet.prototype.settingChanged = function(result, id) {
        var observable = self.settings[result.key];
        observable(result.value);
    }
    comet.addEvent(3000, 'settingChanged');

    soundManager.setup({
        url: '/swf/',
        debugMode: false,
        onready: function() {
            soundManager.createSound({ id : 's', url : '/audio/1.mp3' });
        }
    });
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
}
