/*
 * Редактирование сообщения
 * Событие о прочтении
 * Дружба из интерфейса (отправить запрос, подтвердить запрос, отклонить запрос) удалить из друзей???
 * Сообщения о дружбе в сообщениях??? https://docs.google.com/a/happy-giraffe.ru/file/d/0B0p9kphKu95ObDVQbE1lOHZkQTQ/edit
 * Добавление в чёрный список и друзья (сложные отношения)
 * При поиске необходимо убрать выделения с других вкладок, после закрытия поиска необходимо вернуться на вкладку до поиска
 * Счётчик сообщений только на новых
 */

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
					}
				});
			}
			comet.addEvent(2083, 'messagingContactsUpdateCount');
			// Мониторинг онлайна
			Comet.prototype.messagingUserOnline = function(result, id) {
				ko.utils.arrayForEach(self.objects, function(obj) {
					if (obj.id == result.user.id) {
						obj.isOnline(result.user.online);
						// Применить фильтр
						// Так же нужно обновить счётчики
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
			comet.addEvent(2072, 'messagingUserFriends');
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

function MessagingUser(model) {
	// Атрибуты модели пользователя
	self.id = model.id;
	self.firstName = model.firstName;
	self.lastName = model.lastName;
	self.gender = model.gender;
	self.avatar = model.avatar;
	self.channel = model.channel;
	// Состояния пользователя
	self.isShow = ko.observable(true);
	self.isFriend = ko.observable(model.isFriend);
	self.isBanned = ko.observable(model.isBanned);
	self.isOnline = ko.observable(model.isOnline);
	// Количество новых сообщений
	self.countNew = ko.observable(count);
	// Дата последнего сообщения в диалоге
	self.date = ko.observable(date);

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
						obj.dtimeDelete = result.message.dtimeDelete;
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

function MessagingMessage(model) {
	self.id = model.id;
	self.from = null;
	self.to = null;
	self.text = model.text;
	self.created = model.created;
	self.read = ko.observable(model.read);
	self.dtimeDelete = ko.observable(null);
	self.images = model.images;

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
			// Обновление счётчика непрочитанных сообщений и даты последнего сообщения
			Comet.prototype.messagingThread = function(result, id) {
				ko.utils.arrayForEach(self.objects, function(obj) {

				});
			}
			comet.addEvent(2083, 'messagingContactsUpdateCount');
		}
	}
}

function MessagingThread(me, user, messages) {
	var self = this;
	self.id = me.id;
	self.me = me;
	self.user = user;
	self.messages = ko.observableArray([]);
	// Текст нового сообщения
	self.editor = ko.observable('');

	// Текст конструктора
	self.messages = ko.utils.arrayForEach(messages, function(message) {
		self.messages.push(new MessagingMessage(message));
	});
}

function Messaging(model) {
	var self = this;
	self.users = ko.observableArray([]);
	self.threads = ko.observableArray([]);
	self.me = null;
	self.countTotal = ko.observable(model.counters.countTotal);
	// Есть проблема с обновлением счётчиков онлайн по событиям
	self.countOnline = ko.observable(model.counters.countTotal);
	self.countFriendsOnline = ko.observable(model.counters.friendsOnline);

	// Событие на обновление счётчиков новых сообщений
	Comet.prototype.messagingUpdateCounters = function(result, id) {
		self.countNew(result.counters.total);
		self.countNew(result.counters.online);
		self.countNew(result.counters.friendsOnline);
	};
	comet.addEvent(2080, 'messagingContactsUpdateCounters');

	// Текст конструктора
	ko.utils.arrayForEach(model.users, function(user) {
		self.users.push(new MessagingUser(user));
	});
	self.me = new MessagingUser(model.me);
/*	ko.utils.arrayForEach(model.threads, function(thread) {
		self.threads.push(new MessagingThread(me, ));
	});*/
}
