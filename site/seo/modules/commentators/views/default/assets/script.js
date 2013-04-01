/**
 * Author: alexk984
 * Date: 01.04.13
 */
function CommentatorTasks(data, commentators_data) {
    var self = this;
    self.addProcess = ko.observable(0);
    self.newTask = ko.observable(new newEditorTask());
    var days = [];
    for (var key in data)
        days.push(new EditorTaskDay(data[key], key));
    self.days = ko.observableArray(days);

    var commentators = [];
    for (var key in commentators_data)
        commentators.push(new CommentatorView(commentators_data[key]));
    self.commentators = ko.observableArray(commentators);

    self.executors = ko.observableArray([]);
    self.non_executors = ko.observableArray([]);

    setTimeout(function () {
        refreshOdd('table.task-tb_tb tr', 'task-tb_odd');
    }, 100);

    self.showCommentators = function (task) {
        self.executors.removeAll();
        self.non_executors.removeAll();
        for (var key in task.executors) {
            for (var key2 in self.commentators()) {
                var commentator = self.commentators()[key2];
                if (commentator.id == task.executors[key])
                    self.executors.push(commentator);
            }
        }

        for (var key in task.non_executors) {
            for (var key2 in self.commentators()) {
                var commentator = self.commentators()[key2];
                if (commentator.id == task.non_executors[key])
                    self.non_executors.push(commentator);
            }
        }

        refreshOdd('#executors_list .popup-commentator-task_user', 'popup-commentator-task_user__odd');
        refreshOdd('#non_executors_list .popup-commentator-task_user', 'popup-commentator-task_user__odd');
    };

    self.startAddTask = function () {
        self.addProcess(1);
    }
}

function EditorTaskDay(data, date) {
    var self = this;

    self.date = date;
    var tasks = [];
    for (var key in data)
        tasks.push(new EditorTask(data[key]));
    self.tasks = ko.observableArray(tasks);
}

function EditorTask(data) {
    var self = this;

    self.id = data['id'];
    self.type = data['type'];
    self.status = ko.observable(data['status']);
    self.article_title = data['article_title'];
    self.article_url = data['article_url'];
    self.executors = data['executors'];
    self.non_executors = data['non_executors'];

    self.typeClass = ko.computed(function () {
        if (self.type == 1)
            return 'task-tb_ico__comment';
        return 'task-tb_ico__like';
    });
    self.pause = function () {
        $.post('/commentators/pause/', {id: self.id}, function (response) {
            if (response.status) {
                if (self.status() == 1)
                    self.status(0);
                else
                    self.status(1);
                refreshOdd('table.task-tb_tb tr', 'task-tb_odd');
            }
        }, 'json');
    };
    self.activeClass = ko.computed(function () {
        if (self.status() == 0)
            return 'task-tb_task-inactive';
        return '';
    });
    self.statusClass = ko.computed(function () {
        if (self.status() == 0)
            return 'task-tb_playerbar__play';
        return '';
    });

    self.showExecutors = function () {
        commentator_tasks.showCommentators(self);
    }
}

function newEditorTask() {
    var self = this;
    self.page_id = ko.observable(null);
    self.article_title = ko.observable(null);
    self.article_url = ko.observable(null);
    self.addCommentTask = function () {
        self.addTask(1);
    };
    self.addLikeTask = function () {
        self.addTask(2);
    };
    self.addTask = function (type) {
        $.post('/commentators/addTask/', {page_id: self.page_id, type: type}, function (response) {
            if (response.status) {
                self.article_title(null);
                self.article_url(null);
                self.page_id(null);

                var task = new EditorTask(response.data);
                ko.utils.arrayForEach(commentator_tasks.days(), function (day) {
                    if (day.date == response.date){
                        day.tasks.unshift(task);
                    }
                });
                commentator_tasks.addProcess(0);
                refreshOdd('table.task-tb_tb tr', 'task-tb_odd');
            }
        }, 'json');
    };

    self.loadPage = function(){
        $.post('/commentators/loadPage/', {url: self.article_url()}, function (response) {
            console.log(response);
            if (response.status) {
                self.article_title(response.article_title);
                self.page_id(response.page_id);
            }else
                alert(response.error);
        }, 'json');
    };

    self.cancel = function(){
        self.article_title(null);
        self.article_url(null);
        self.page_id(null);
    }
}

function CommentatorView(data) {
    var self = this;

    self.id = data['id'];
    self.name = data['name'];
    self.ava = data['ava'];

    self.getUrl = ko.computed(function () {
        return 'http://www.happy-giraffe.ru/user/' + self.id + '/';
    });
}