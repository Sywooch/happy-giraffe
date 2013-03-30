/**
 * Управление задачами комментатора
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

var commentator_active_block = 0;
var commentator_replace_post = null;

function CommentatorPanel(data) {
    var self = this;
    self.editorTasks = ko.observableArray([]);
    for (var key in data['tasks'])
        self.editorTasks.push(new EditorTask(data['tasks'][key], self));

    self.nextComment = new NextComment(data['comments']);
    self.blogTasks = new KeywordTaskBlock(data['blog'], 0, self);
    self.clubsTasks = new KeywordTaskBlock(data['club'], 1, self);
    self.emptyTasks = ko.observable(new KeywordTaskBlock([], 2, self));

    self.updateTask = function (task_id) {
        ko.utils.arrayForEach(self.editorTasks(), function (task) {
            if (task.id == task_id)
                task.closed(1);
        });
    };
    self.showEmptyTasks = function () {
        $.post('/commentator/emptyTasks/', function (response) {
            self.emptyTasks(new KeywordTaskBlock(response, 2, self));
            console.log($('#showKeywords'));
            $('#showKeywords').trigger('click');
        }, 'json');
    };
}

function KeywordTaskBlock(data, block, parent) {
    var self = this;
    self.parent = parent;
    self.block = block;
    self.tasks = ko.observableArray([]);
    for (var key in data) {
        var task = new CommentatorTask(data[key], self);
        self.tasks.push(task);
    }

    self.HintIsVisible = ko.computed(function () {
        var visible = true;
        ko.utils.arrayForEach(self.tasks(), function (task) {
            if (task.closed() == 0)
                visible = false;
        });
        return visible;
    });

    self.showEmptyTasks = function (replace) {
        if (replace != true)
            commentator_replace_post = null;
        commentator_active_block = self.block;
        self.parent.showEmptyTasks();
    };
}

function CommentatorTask(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = data['id'];
    self.closed = ko.observable(data['closed']);
    self.keyword = ko.observable(data['keyword']);
    self.keyword_id = ko.observable(data['keyword_id']);
    self.keyword_wordstat = ko.observable(data['keyword_wordstat']);
    self.article_title = ko.observable(data['article_title']);
    self.article_url = ko.observable(data['article_url']);

    self.isClosed = ko.computed(function () {
        return self.closed() == 1;
    });
    self.getClass = ko.computed(function () {
        if (self.keyword_wordstat() < 500)
            return 'keyword__micro';
        if (self.keyword_wordstat() < 1500)
            return 'keyword__low';
        if (self.keyword_wordstat() < 10000)
            return 'keyword__middle';
        return 'keyword__high';
    });
    self.wordstatText = ko.computed(function () {
        if (self.keyword_wordstat() < 500)
            return 'МЧ';
        if (self.keyword_wordstat() < 1500)
            return 'НЧ';
        if (self.keyword_wordstat() < 10000)
            return 'СЧ';
        return 'ВЧ';
    });
    self.confirm = function () {
        $.post('/commentator/executed/', {id: self.id, url: self.article_url}, function (response) {
            if (response.status) {
                self.closed(1);
                self.article_title(response.article_title);
            }
            else
                alert(response.error);
        }, 'json');
    };
    self.CancelTask = function () {
        $.post('/commentator/cancelTask/', {id: self.id}, function (response) {
            if (response.status)
                self.parent.tasks.remove(self);
            else
                alert(response.error);
        }, 'json');
    };
    self.replaceTask = function () {
        commentator_replace_post = self;
        self.parent.showEmptyTasks(true);
    };
    self.take = function () {
        if (commentator_replace_post != null)
            commentator_replace_post.CancelTask();

        $.post('/commentator/take/', {id: self.id, block: commentator_active_block}, function (response) {
            if (response.status) {
                self.parent.parent.emptyTasks().tasks.remove(self);
                if (commentator_active_block == 0) {
                    self.parent.parent.blogTasks.tasks.push(self);
                    self.parent = self.parent.parent.blogTasks;
                }
                if (commentator_active_block == 1) {
                    self.parent.parent.clubsTasks.tasks.push(self);
                    self.parent = self.parent.parent.clubsTasks;
                }

                $.fancybox.close();
            }
            else
                alert(response.error);
        }, 'json');
    };
}

function NextComment(data) {
    var self = this;
    self.url = ko.observable(data['url']);
    self.title = ko.observable(data['title']);
    self.count = ko.observable(data['count']);
    self.skip = function () {
        $.post('/commentator/skip/', function (response) {
            if (response.status) {
                self.url(response.url);
                self.title(response.title);
            }
            else
                alert('Можно пропустить не более 30 комментариев в день');
        }, 'json');
    };
    self.progress = ko.computed(function () {
        return self.count()+'%';
    });
    self.incComment = function (data) {
        if (data.inc == 1)
            self.count(self.count() + 1);
        if (data.hasOwnProperty('url')){
            self.url(data.url);
            self.title(data.title);
        }
    };
}

function EditorTask(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = data['id'];
    self.type = data['type'];
    self.closed = ko.observable(data['closed']);
    self.article_title = ko.observable(data['article_title']);
    self.article_url = ko.observable(data['article_url']);

    self.typeClass = ko.computed(function () {
        if (self.type == 1)
            return 'editor-tasks_ico__comment';
        return 'editor-tasks_ico__like';
    });
}


/**
 *
 * Сигналы обновления данных
 */
Comet.prototype.CommentatorPanelUpdateTask = function (result, id) {
    CommentatorPanel.updateTask(result.task_id);
};
Comet.prototype.CommentatorPanelIncComments = function (result, id) {
    commentator_panel.nextComment.incComment(result);
};

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdateTask');
    comet.addEvent(10, 'CommentatorPanelIncComments');
});