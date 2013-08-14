var ENTER_KEY_SEND = 1;
function CommentViewModel(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);
    self.opened = ko.observable(false);
    self.gallery = ko.observable(data.gallery);
    self.objectName = ko.observable(data.objectName);
    self.editor = null;

    self.comments = ko.observableArray([]);
    self.comments(ko.utils.arrayMap(data.comments, function (comment) {
        return new NewComment(comment, self);
    }));
    self.enterSetting = ko.observable(data.messaging__enter);
    self.enterSetting.subscribe(function (a) {
        $.post('/ajax/setUserAttribute/', { key: 'messaging__enter', value: a ? 1 : 0 });
        ENTER_KEY_SEND = a;
    });
    ENTER_KEY_SEND = self.enterSetting();

    self.sending = ko.observable(false);
    self.focusEditor = function () {
        setTimeout(function () {
            self.editor.redactor('focusEnd');
        }, 100);
    };

    self.getCount = ko.computed(function () {
        return self.allCount();
    });

    self.openComment = function () {
        if (!self.opened()){
            self.opened(true);
            ko.utils.arrayForEach(self.comments(), function (comment) {
                if (comment.editMode())
                    comment.editMode(false);
            });

            self.initEditor('add_' + self.objectName());
        }
        self.focusEditor();
    };

    self.Enter = function () {
        if (self.enterSetting())
            self.addComment();
    };
    self.addComment = function () {
        if (!self.sending()) {
            self.sending(true);
            self.disableInput();
            $.post('/ajaxSimple/addComment/', {entity: self.entity(), entity_id: self.entity_id(), response_id: self.responseId(), text: self.getMessageText()},
                function (response) {
                    if (response.status) {
                        self.opened(false);
                        self.comments.push(new NewComment(response.data, self));
                        self.allCount(self.allCount() + 1);
                        if (self.gallery()) {
                            $('.photo-window_right').animate({ scrollTop: $('.comments-gray').height() + 500 }, "fast");
                            $('#add_' + self.objectName()).val('').removeAttr('readonly');
                        }
                    }
                    self.sending(false);
                }, 'json');
        }
    };
    self.goBottom = function () {
        $('body').stop().animate({scrollTop: $('#content').height()}, "normal");
        self.openComment();
    };
    self.initEditor = function (id) {
        self.editor = $('#' + id);
        if (!self.gallery()) {
            $('#' + id).redactor({
                minHeight: 68,
                autoresize: true,
                buttons: ['bold', 'italic', 'underline', 'image', 'video', 'smile'],
                buttonsCustom: {
                    smile: {
                        title: 'smile',
                        callback: function (buttonName, buttonDOM, buttonObject) {
                            // your code, for example - getting code
                            var html = this.get();
                        }
                    }
                }
            });
            self.focusEditor();
        }
    };

    self.disableInput = function () {
        $('#add_' + self.objectName()).attr('readonly', 'readonly');
    };

    self.getMessageText = function () {
        if (self.gallery()) {
            if (self.editor == null)
                return $('#add_' + self.objectName()).val();
            else
                return self.editor.val();
        } else
            return self.editor.html();
    };

    /*************************************** reply ****************************************/
    self.response = ko.observable(false);
    self.responseId = ko.computed(function () {
        if (self.response())
            return self.response().id;
        else
            return '';
    });
    self.removeResponse = function(){
        var str = self.editor.html();
        str = str.replace('<span data-redactor="verified" class="a-imitation">' + self.response().author.firstName() + ',</span>','');
        str = str.replace('<span class="a-imitation">' + self.response().author.firstName() + ',</span>','');
        self.editor.html(str);
        self.response(false);
    };

    self.Reply = function (comment) {
        self.response(comment);
        self.goBottom();
        self.editor.html('<span class="a-imitation">' + comment.author.firstName() + ',</span>&nbsp;');
    };
}

function NewComment(data, parent) {
    var self = this;
    self.parent = parent;
    self.removed = ko.observable(false);
    self.editMode = ko.observable(false);
    ko.mapping.fromJS(data, {}, self);

    self.author = new User(data['author']);
    self.ownComment = ko.computed(function () {
        return CURRENT_USER_ID == self.author.id();
    });
    self.canAdmin = ko.computed(function () {
        return self.canEdit() || self.canRemove();
    });
    self.albumPhoto = ko.computed(function () {
        return self.photoUrl() !== false;
    });

    self.Like = function () {
        if (CURRENT_USER_ID != self.author.id()) {
            $.post('/ajaxSimple/commentLike/', {id: self.id}, function (response) {
                if (response.status) {
                    if (self.userLikes()) {
                        self.userLikes(false);
                        self.likesCount(self.likesCount() - 1);
                    } else {
                        self.userLikes(true);
                        self.likesCount(self.likesCount() + 1);
                    }
                }
            }, 'json');
        }
    };

    self.GoEdit = function () {
        self.editMode(true);
        $('#text' + self.id()).val(self.html());
        self.parent.initEditor('text' + self.id());
        ko.utils.arrayForEach(self.parent.comments(), function (comment) {
            if (comment.id() != self.id())
                if (comment.editMode())
                    comment.editMode(false);
            self.parent.opened(false);
        });
    };

    self.Edit = function () {
        var text = self.parent.getMessageText();
        $.post('/ajaxSimple/editComment/', {id: self.id(), text: text}, function (response) {
            if (response.status) {
                if (!self.parent.gallery())
                    self.parent.editor.redactor('destroy');
                self.editMode(false);
                self.html(response.text);
            }
        }, 'json');
    };

    self.Remove = function () {
        $.post('/ajaxSimple/deleteComment/', {id: self.id()}, function (response) {
            if (response.status) {
                self.removed(1);
                self.parent.allCount(self.parent.allCount() - 1);
            }
        }, 'json');
    };

    self.Restore = function () {
        $.post('/ajaxSimple/restoreComment/', {id: self.id()}, function (response) {
            if (response.status) {
                self.removed(0);
                self.parent.allCount(self.parent.allCount() + 1);
            }
        }, 'json');
    };

    self.Reply = function () {
        self.parent.Reply(self);
    };

    self.Enter = function () {
        if (self.parent.enterSetting() || self.parent.gallery()) {
            self.Edit();
            return false;
        }
        return true;
    };
}

function User(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);

    self.fullName = ko.computed(function () {
        return self.firstName() + ' ' + self.lastName();
    }, this);

    self.avatarClass = ko.computed(function () {
        return self.gender() == 0 ? 'female' : 'male';
    }, this);
}

ko.bindingHandlers.enterKey = {
    init: function (element, valueAccessor, allBindings, vm) {
        ko.utils.registerEventHandler(element, "keypress", function (event) {
            if (event.keyCode === 13) {
                ko.utils.triggerEvent(element, "change");
                valueAccessor().call(vm, vm);
                if (ENTER_KEY_SEND)
                    return false;
            }
            return true;
        });
    }
};
