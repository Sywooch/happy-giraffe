function CommentViewModel(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);

    self.comments = ko.observableArray([]);
    self.comments(ko.utils.arrayMap(data['comments'], function (comment) {
        return new NewComment(comment, self);
    }));

    self.getCount = ko.computed(function () {
        return self.allCount();
    });

    self.addComment = function () {

    }
}

function NewComment(data, parent) {
    var self = this;
    self.parent = parent;
    self.removed = ko.observable(false);
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

    self.Edit = function () {

    };
    self.Remove = function () {
        $.post('/ajaxSimple/deleteComment/', {id: self.id()}, function (response) {
            if (response.status){
                self.removed(1);
                self.parent.allCount(self.parent.allCount() - 1);
            }
        }, 'json');
    };
    self.Restore = function () {
        $.post('/ajaxSimple/restoreComment/', {id: self.id()}, function (response) {
            if (response.status){
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
