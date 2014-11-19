define(['jquery', 'knockout', 'models/CommentsController', 'models/UserController', 'text!comment-widget/comment-widget.html', 'moment', 'models/Model', 'models/Comment', 'models/User', 'care-wysiwyg', 'knockout.mapping', 'ko_library'], function($, ko, CommentsController, UserData, template, moment, Model, Comment, User) {

    var CommentWidgetViewModel = function (params) {

        comet.addChannel(params.channelId);

        this.commentsDataQueue = [];

        this.parsedData = ko.mapping.fromJS([]);

        this.authUser = ko.mapping.fromJS({});

        this.editing = ko.observable(false);

        this.editor = ko.observable('');

        this.cacheData = {};

        this.loaded = ko.observable(false);

        this.entityId = (ko.isObservable(params.entityId) === false) ? params.entityId : params.entityId();
        /**
         * Comet Создания комментария
         */

        this.newCommentAddedEvent = function newCommentAddedEvent(result) {

            this.cacheData = result;
            if (this.cacheData.responseId !== 0) {
                Model.get(User.getUserUrl, { id: result.authorId, avatarSize: CommentsController.commentAvatarSize }).done(this.answerAdded.bind(this));
            } else {
                Model.get(User.getUserUrl, { id: result.authorId, avatarSize: CommentsController.commentAvatarSize }).done(this.getNewUser.bind(this));
            }
        };

        Comet.prototype.newCommentAdded = this.newCommentAddedEvent.bind(this);

        comet.addEvent(2510, 'newCommentAdded');

        this.getNewUser = function getNewUser(userData) {
            this.parsedData.unshift(CommentsController.newCommentAddedUser(this.cacheData, userData, this.parsedData()));
        };


        this.answerAdded = function answerAdded(userData) {
            var answerObject = CommentsController.newAnswer(this.cacheData, userData, this.parsedData());
            this.parsedData()[answerObject.parentId].answers.push(answerObject.comment);
        };

        /**
         * Comet Обновление комментария
         */
        this.renewCommentAddedEvent = function renewCommentAddedEvent(result) {

            var commentObj,
                commentRootId,
                commentChildId;

            if (result.responseId !== 0) {
                commentRootId = CommentsController.findIfAnswer(result, this.parsedData());
                commentChildId = CommentsController.findInAnswers(result, this.parsedData()[commentRootId].answers());
                if (commentChildId !== undefined) {
                    this.parsedData()[commentRootId].answers()[commentChildId].purifiedHtml(result.purifiedHtml);
                }

            } else {
                commentObj = CommentsController.removedStatus(result, this.parsedData());

                if (commentObj !== undefined) {
                    this.parsedData()[commentObj].purifiedHtml(result.purifiedHtml);
                }
            }

        };

        Comet.prototype.renewCommentAdded = this.renewCommentAddedEvent.bind(this);

        comet.addEvent(2520, 'renewCommentAdded');


        /**
         * Comet Удаление комментария
         */

        this.commentRemovedEvent = function commentRemovedEvent(result) {
            var commentRootId,
                commentChildId,
                commentObj;
            if (result.responseId !== 0) {
                commentRootId = CommentsController.findIfAnswer(result, this.parsedData());
                commentChildId = CommentsController.findInAnswers(result, this.parsedData()[commentRootId].answers());
                if (commentChildId !== undefined) {
                    this.parsedData()[commentRootId].answers()[commentChildId].removed(true);
                }

            } else {
                commentObj = CommentsController.removedStatus(result, this.parsedData());

                if (commentObj !== undefined) {
                    this.parsedData()[commentObj].removed(true);
                }
            }
        };

        Comet.prototype.commentRemoved = this.commentRemovedEvent.bind(this);

        comet.addEvent(2530, 'commentRemoved');

        /**
         * Comet Восстановление комментария
         */

        this.commentRestoredEvent = function commentRestoredEvent(result) {

            var commentRootId,
                commentChildId,
                commentObj;


            if (result.responseId !== 0) {
                commentRootId = CommentsController.findIfAnswer(result, this.parsedData());
                commentChildId = CommentsController.findInAnswers(result, this.parsedData()[commentRootId].answers());
                if (commentChildId !== undefined) {
                    this.parsedData()[commentRootId].answers()[commentChildId].removed(false);
                }

            } else {
                commentObj = CommentsController.removedStatus(result, this.parsedData());

                if (commentObj !== undefined) {
                    this.parsedData()[commentObj].removed(false);
                }
            }
        };

        Comet.prototype.commentRestored = this.commentRestoredEvent.bind(this);

        comet.addEvent(2540, 'commentRestored');


        this.setEditing = function() {
            this.editing(true);
        };

        /**
         * Конец редактирования
         */
        this.cancelEditor = function cancelEditor() {
            this.editor('');
            this.editing(false);
        };

        /**
         * Добавление комментария
         */
        this.addComment = function addComment() {
            var commentText = this.editor();
            if (!Comment.isRedactorStringEmpty(commentText)) {
                Model.get(Comment.createCommentUrl, CommentsController.createComment(params.entity, this.entityId, this.editor(), undefined)).done(this.cancelEditor.bind(this));
            }
        };

        /**
         * Удаление комментария
         */
        this.deleteComment = function deleteComment() {
            var commentText = this.editor();
            if (!Comment.isRedactorStringEmpty(commentText)) {
                Model.get(Comment.createCommentUrl, CommentsController.createComment(params.entity, this.entityId, this.editor(), undefined));
            }
        };


        /**
         * Конфигурация редактора
         * @type {{minHeight: number, buttons: string[], plugins: string[], callbacks: {init: *[]}}}
         */
        this.editorConfig = {
            minHeight: 88,
            buttons: ['bold', 'italic', 'underline'],
            plugins: ['imageCustom', 'smilesModal', 'videoModal'],
            callbacks: {
                init: [
                ]
            }
        };

        /**
         * Начало редактирования
         * @param message
         */
        this.beginEditing = function(message) {
            this.editor(message.text());
            this.setEditing();
        };

        /**
         * Конец редактирования
         */
        this.cancelEditing = function cancelEditing() {
            this.editor('');
            this.editing(false);
        };

        /**
         * После получение всей информации
         * @param userData
         */
        this.allEventsSucceed = function usersSucceed(userData) {
            ko.mapping.fromJS(UserData.getCurrentUserFromList(userData.data, userData.success), this.authUser);
            console.log(UserData.getCurrentUserFromList(userData.data, userData.success));
            this.parsedData = ko.mapping.fromJS(CommentsController.allDataReceived(userData.data, this.commentsDataQueue.commentsData), this.parsedData);
            this.loaded(true);
        };

        /**
         * После получения данных комментария, получаем юзеров
         * @param data
         */
        this.dataGetSucceed = function (data) {
            this.commentsDataQueue = CommentsController.parseData(data);
            Model.get(User.getUserUrl, this.commentsDataQueue.userPack).done(this.allEventsSucceed.bind(this));
        };

        /**
         * Получение комментария
         * @type {Object}
         */
        this.commentDataParams = CommentsController.getListData(params.entity, this.entityId, params.listType);

        /**
         * Запрос комментариев
         */
        Model.get(Comment.getListUrl, this.commentDataParams).done(this.dataGetSucceed.bind(this));
    };

    return {
        viewModel: CommentWidgetViewModel,
        template: template
    };
});