function CommentViewModel(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);
    self.opened = ko.observable(false);

    self.comments = ko.observableArray([]);
    self.comments(ko.utils.arrayMap(data['comments'], function (comment) {
        return new NewComment(comment, self);
    }));

    self.getCount = ko.computed(function () {
        return self.allCount();
    });

    self.openComment = function (data, event) {
        self.opened(true);
        var input = $(event.target).next();
        input.redactor({
            imageGetJson: '/tests/images.json',
            imageUpload: '/webUpload/redactor/uploadImage/',
            fileUpload: '/webUpload/redactor/fileUpload/'
        });
        setTimeout(function () {
            input.focus();
        }, 100);
    };
    self.addComment = function () {
        var text = $('#new' + self.objectName()).val();
        $.post('/ajaxSimple/addComment/', {
            entity: self.entity(),
            entity_id: self.entity_id(),
            text: text
        }, function (response) {
            if (response.status) {
                self.opened(false);
                $('#new' + self.objectName()).val('').redactor('destroy');
                self.comments.push(new NewComment(response.data, self));
                self.allCount(self.allCount() + 1);
            }
        }, 'json');
    };
    self.goBottom = function () {
        console.log($('.layout-container').height());
        $('.layout-container').stop().animate({scrollTop: $('#layout').height()}, "normal");
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
        input.redactor({
            imageGetJson: '/tests/images.json',
            imageUpload: '/webUpload/redactor/uploadImage/',
            fileUpload: '/webUpload/redactor/fileUpload/'
        });
        setTimeout(function () {
            input.focus();
        }, 100);
    };

    self.Edit = function () {
        var input = $('#text' + self.id());
        $.post('/ajaxSimple/editComment/', {id: self.id(), text: input.val()}, function (response) {
            if (response.status) {
                input.redactor('destroy');
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
