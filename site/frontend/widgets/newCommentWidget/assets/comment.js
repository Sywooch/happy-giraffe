function CommentViewModel(data) {
    var self = this;
    self.entity = data['entity'];
    self.entity_id = data['entity_id'];
    self.full = data['full'];

    self.comments = ko.observableArray([]);
    self.comments(ko.utils.arrayMap(data['comments'], function(comment) {
        return new NewComment(comment, self);
    }));

    self.getCount = ko.computed(function () {
        return self.comments().length;
    });

    self.addComment = function(){

    }
}

function NewComment(data, parent){
    var self = this;
    self.parent = parent;
    self.id = data['id'];
    self.created = ko.observable(data['created']);
    self.html = ko.observable(data['html']);

    self.author_id = ko.observable(data['author_id']);
    self.author_name = ko.observable(data['author_name']);
    self.author_url = ko.observable(data['author_url']);
    self.own = ko.observable(data['own']);

    self.likesCount = ko.observable(data['likesCount']);
    self.userLikes = ko.observable(data['userLikes']);
}

NewComment.prototype.reply = function (comment_id) {

};


var Comments = {
    like: function (el, id) {
        if (!$(el).hasClass('disable'))
            $.post('/ajaxSimple/commentLike/', {id: id}, function (response) {
                if (response.status) {
                    $(el).toggleClass('active');
                    var count = parseInt($(el).text());

                    if ($(el).hasClass('active')) {
                        $(el).text(count + 1);
                        $(el).removeClass('hide');
                    } else {
                        $(el).text(count - 1);
                        if (count == 1)
                            $(el).addClass('hide');
                    }

                }
            }, 'json');
    }
}