function CommentViewModel(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);
    self.opened = ko.observable(false);
    self.editor = null;

    self.comments = ko.observableArray([]);
    self.comments(ko.utils.arrayMap(data['comments'], function (comment) {
        return new NewComment(comment, self);
    }));
    self.enterSetting = ko.observable(data.messaging__enter);
    self.enterSetting.subscribe(function(a) {
        $.post('/ajax/setUserAttribute/', { key : 'messaging__enter', value : a ? 1 : 0 });
    });
    self.sending = ko.observable(false);
    self.focusEditor = function(){
        self.editor.focus();
        return true;
    };

    self.getCount = ko.computed(function () {
        return self.allCount();
    });

    self.openComment = function (data, event) {
        self.opened(true);
        self.initEditor('add_'+self.objectName());
        setTimeout(function () {self.focusEditor()}, 100);
    };

    self.Enter = function(){
        if (self.enterSetting()){
            self.addComment();
        }
    };
    self.addComment = function () {
        if (!self.sending()){
            self.sending(true);
            var text = self.editor.html();
            $.post('/ajaxSimple/addComment/', {
                entity: self.entity(),
                entity_id: self.entity_id(),
                text: text
            }, function (response) {
                if (response.status) {
                    self.opened(false);
                    self.getEditor().redactor('destroy');
                    self.comments.push(new NewComment(response.data, self));
                    self.allCount(self.allCount() + 1);
                }
                self.sending(false);
            }, 'json');
        }
    };
    self.goBottom = function () {
        $('.layout-container').stop().animate({scrollTop: $('#layout').height()}, "normal");
    };

    self.initEditor = function(id){
        self.editor = $('#'+id);
        $('#'+id).redactor({
            minHeight: 68,
            autoresize: true,
            buttons: ['bold', 'italic', 'underline', 'image', 'video', 'smile'],
            buttonsCustom: {
                smile: {
                    title: 'smile',
                    callback: function(buttonName, buttonDOM, buttonObject) {
                        // your code, for example - getting code
                        var html = this.get();
                    }
                }
            }
        });
    }
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
        var input = $('#text' + self.id());
        input.val(self.html());
        self.parent.initEditor('text' + self.id());

        setTimeout(function () {
            input.focus();
        }, 100);
    };

    self.Edit = function () {
        var text = self.parent.editor.html();
        $.post('/ajaxSimple/editComment/', {id: self.id(), text: text}, function (response) {
            if (response.status) {
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

    };

    self.Enter = function(){
        if (self.parent.enterSetting()){
            self.Edit();
        }

        return false;
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
    init: function(element, valueAccessor, allBindings, vm) {
        ko.utils.registerEventHandler(element, "keyup", function(event) {
            if (event.keyCode === 13) {
                ko.utils.triggerEvent(element, "change");
                valueAccessor().call(vm, vm);
            }

            return true;
        });
    }
};
