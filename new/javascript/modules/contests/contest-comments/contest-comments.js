define(['jquery', 'knockout', 'models/Model', 'models/ContestComments', 'models/Comment', 'models/User', 'text!contests/contest-comments/contest-comments.html'], function ContestCommentsViewHandler($, ko, Model, ContestComments, Comment, User, template) {
    function ContestCommentsViewModel(params) {
        this.contest = Object.create(ContestComments);
        this.defaultTitle = 'Последние комментарии';
        this.contest.id = params.contestId;
        this.contest.userId = params.userId || null;
        this.title = params.title || this.defaultTitle;
        this.contest.commentsLimit = params.limit || this.contest.commentsLimit;
        this.usersPile = [];
        this.users = [];
        this.avatarSize = 40;
        this.loading = ko.observable(true);
        /**
         * pilingUsers - сбор id юзеров
         *
         * @param  int userId
         * @return
         */
        this.pilingUsers = function pilingUsers(userId) {
            userId = userId;
            if ($.inArray(userId, this.usersPile) === -1) {
                this.usersPile.push(userId);
            }
        };

        /**
         * mappingCommentsArray - образование объекта комментария
         *
         * @param  Object object объект комментария и сущности с ним связанного
         * @return {type}
         */
        this.mappingCommentsArray = function mappingCommentsArray(object) {
            var newComment = Object.create(Comment);
            object.comment = newComment.init(object.comment);
            this.pilingUsers(object.comment.authorId);
            if (object.entity) {
                object.entity.userId = parseInt(object.entity.userId);
                this.pilingUsers(object.entity.userId);
            }
            return object;
        };

        /**
         * mappingPutUsersInComments - присоединяем пользователей к объектам комментариев и сущности
         *
         * @param  Object object объект комментария и сущности с ним связанного
         * @return Object
         */
        this.mappingPutUsersInComments = function mappingPutUsersInComments(object) {
            var st;
            if (object.comment) {
                st = Model.findById(object.comment.authorId, this.users);
                if (st) {
                    object.comment.user = st;
                }
            }
            if (object.entity) {
                st = Model.findById(object.entity.userId, this.users);
                if (st) {
                    object.entity.user = st;
                }
            }
            return object;

        };

        /**
         * downingUsers - получение юзеров пачкой
         *
         * @param  int avatarSize размер аватара
         * @return Deffered
         */
        this.downingUsers = function downingUsers(avatarSize) {
            return Model.get(User.getUserUrl, { pack: User.createPackList(this.usersPile), avatarSize: avatarSize});
        };

        /**
         * parseUsers - парсинг пачки пользователей
         *
         * @param  Object response объект ответа
         * @return
         */
        this.parseUsers = function parseUsers(response) {
            if (response.success === true) {
                this.users = ko.utils.arrayMap(response.data, User.parsePack);
            }
        };

        /**
         * putUsersInComments - запускаем размещение пользователей в комментарии
         *
         * @return
         */
        this.putUsersInComments = function putUsersInComments() {
            this.contest.comments(ko.utils.arrayMap(this.contest.comments(), this.mappingPutUsersInComments.bind(this)));
            this.loading(false);
        };

        /**
         * resolveContestComments - парсим изначальную информацию о комментариях и сущностях
         *
         * @param  Object response объект ответа
         * @return
         */
        this.resolveContestComments = function resolveContestComments(response) {
            if (response.success === true) {
                this.usersPile = [];
                this.contest.comments(ko.utils.arrayMap(response.data, this.mappingCommentsArray.bind(this)));
                if (this.contest.comments().length > 0) {
                    this
                        .downingUsers(this.avatarSize)
                            .then(this.parseUsers.bind(this))
                            .done(this.putUsersInComments.bind(this));
                } else {
                    this.loading(false);
                }

            }
        };

        /**
         * reloadComments - перезагрузка блока
         *
         * @return
         */
        this.reload = function reloadComments() {
            this.loading(true);
            this.contest.getContestComments(this.contest.userId).done(this.resolveContestComments.bind(this));
        };
        this.contest.getContestComments(this.contest.userId).done(this.resolveContestComments.bind(this));
    }
    return {
        viewModel: ContestCommentsViewModel,
        template: template
    };
});
