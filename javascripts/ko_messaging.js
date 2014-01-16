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
			Comet.prototype.messagingContactsUpdateCount = function(result, id) {
				ko.utils.arrayForEach(self.objects, function(obj) {
					if (obj.id == result.user.id) {
						obj.countNew(result.count);
						obj.date(result.date);
						// применить фильтр
					}
				});
			}
			comet.addEvent(2083, 'messagingContactsUpdateCount');
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
		}
	},
	// Применить фильтр к контактам
	// Фильтр - это метод, принимающий в качества аргумента модель пользователя
	// И возвращающий значение true/false, означающее показать/скрыть
	applyFilter: function(filter) {
		// Загрузить новые контакты, попадающие под этот фильтр
		// И скрыть лишние
		ko.utils.arrayForEach(self.objects, function(user) {
			user.isShow(this[filter](user));
		});
	}
}

function MessagingUser(viewModel, model) {
	var self = this;
	self.viewModel = viewModel;
	// Атрибуты модели пользователя
	self.id = model.id;
	self.firstName = model.firstName;
	self.lastName = model.lastName;
	self.fullName = function() {
		return self.firstName + ' ' + self.lastName;
	};
	self.gender = model.gender;
	self.avatar = model.avatar;
	self.channel = model.channel;
	// Состояния пользователя
	self.isShow = ko.observable(true);
	self.isFriend = ko.observable(model.isFriend);
	self.isBanned = ko.observable(model.isBanned);
	self.isOnline = ko.observable(model.isOnline);
	self.lastOnline = ko.observable(model.lastOnline);
	self.typing = ko.observable(false);
	self.typingTimer = false;
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
						obj.read = result.message.read;
					}
				});
			};
			comet.addEvent(2011, 'messagingMessageRead');
			// Отмена сообщения
			Comet.prototype.messagingMessageCancelled = function(result, id) {
				for (i in self.objects) {
					var obj = self.objects[i];
					if (obj.id == result.message.id) {
						obj.splice(i, 1);
					}
				}
			}
			comet.addEvent(2011, 'messagingMessageCancelled');
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
			comet.addEvent(2040, 'messagingMessageDeleted');
		}
	}
}

function MessagingMessage(model, thread) {
	var self = this;
	self.thread = thread;
	self.id = model.id;
	self.from = null;
	self.to = null;
	self.isMy = (self.thread.id == model.to_id);
	self.text = model.text;
	self.created = model.created;
	self.dtimeRead = ko.observable(model.dtimeRead);
	self.dtimeDelete = ko.observable(model.dtimeDelete);
	self.hidden = ko.observable(false);
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

	/**
	 * Удаление сообщения
	 */
	self.deleteMessage = function() {
		// Просто отправим запрос, ответ придёт событием
		$.post('/messaging/messages/delete/', {messageId: self.id});
	};
	/**
	 * Восстановление сообщения
	 */
	self.restore = function() {
		// Просто отправим запрос, ответ придёт событием
		$.post('/messaging/messages/restore/', {messageId: self.id});
	};
	
	self.markAsReaded = function() {
		self.dtimeRead(1);
	}
	
	self.show = function() {
		if(!self.dtimeRead() && !timer && self.to.id == Messaging.prototype.currentThread().me.id) {
			timer = setTimeout(function() {
				self.markAsReaded();
			}, 3000);
		}
	};
	self.hide = function() {
		if(!self.dtimeRead()) {
			clearInterval(timer);
			timer = false;
		}
	};

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
						obj.messages.push(new MessagingMessage(result.message));
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
							console.log(message.created);
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
		}
	},
	open: function(user) {
		var thread = ko.utils.arrayFirst(this.objects, function(obj) {
			return obj.user.id == user.id;
		});
		if (!thread) {
			thread = new MessagingThread(user.viewModel.me, user);
		}
		Messaging.prototype.currentThread(thread);
	},
}

function MessagingThread(me, user) {
	var self = this;
	var scroller = '.im-center_middle-hold.scroll_scroller';
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
	self.loadingMessages = ko.observable(false);
	self.fullyLoaded = ko.observable(false);
	self.editing = ko.observable(false);
	self.deletedDialogs = ko.observableArray([]);

	// методы
	self.setEditing = function(data, event) {
		self.editing(true);
	};
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
		var data = {};
		data.interlocutorId = self.id;
		data.text = self.editor();
		//data.images = self.uploadedImagesIds();

		$.post('/messaging/messages/send/', data, function(response) {
			self.sendingMessage(false);

			if (response.success) {
				self.editor('');
				self.uploadedImages([]);
			} else {
				//
			}
		}, 'json');
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
				// Позиция скролла от низа
				var scrollPos = $(scroller).find('.scroll_cont').height() - $(scroller).scrollTop();
				response.messages = response.messages.reverse();
				self.messages(ko.utils.arrayMap(response.messages, function(message) {
					return new MessagingMessage(message, self);
				}).concat(self.messages()));
				if (response.last)
					self.fullyLoaded(true);
				self.loadingMessages(false);
				var jScroller = $(scroller);
				// Выставим скролл
				if(isFirst) { // если первая загрузка
					var firstUnread = jScroller.find('.im-message.im-message__new:eq(0)');
					if(firstUnread.length > 0) { // если есть непрочитанные сообщения
						jScroller.scrollTo(firstUnread, 0); // докрутим до непочитанного сообщения
					} else {
						jScroller.scrollTo('max', 0); // прокрутим в конец
					}
				} else { // последующие загрузки необходимо сделать так, что бы скролл не дёргался
					jScroller.scrollTop(jScroller.find('.scroll_cont').height() - scrollPos);
				}
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
	self.users = ko.observableArray([]);
	self.threads = ko.observableArray([]);
	self.me = null;
	self.countTotal = ko.observable(model.counters.total);

	// Событие на обновление счётчиков новых сообщений
	Comet.prototype.messagingUpdateCounters = function(result, id) {
		self.countTotal(result.counters.total);
	};
	comet.addEvent(2080, 'messagingContactsUpdateCounters');

	// Текст конструктора
	self.users = ko.utils.arrayMap(model.contacts, function(user) {
		return new MessagingUser(self, user);
	});
	self.me = new MessagingUser(self, model.me);
}
