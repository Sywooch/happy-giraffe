define(['jquery', 'knockout', 'models/Model', 'models/Comment', 'models/User', 'text!homepage-onair/homepage-onair.html'], function($, ko, Model, Comment, User, template) {
    function OnAir() {
        this.loadCommentsUrl = '/api/comments/onAir/';
        this.pageLimit = 10;
        this.perPage = 5;
        this.avatarSize = 40;

        this.usersPile = [];
        this.users = [];
        this.comments = ko.observableArray([]);
        this.loading = ko.observable(true);
        this.page = ko.observable(1);

        this.prev = function prev() {
            if (this.page() > 1) {
                this.page(this.page() - 1);
            }
        };

        this.next = function next() {
            if (this.page() < this.pageLimit) {
                this.page(this.page() + 1);
            }
        };

        this.prevActive = ko.computed(function() {
            return this.page() > 1;
        }, this);

        this.nextActive = ko.computed(function() {
            return this.page() < this.pageLimit;
        }, this);

        this.commentsToShow = ko.computed(function() {
            if (this.loading() === true) {
                return [];
            }

            var l = (this.page() - 1) * this.perPage;
            var r = l + this.perPage;

            var idx;
            return ko.utils.arrayFilter(this.comments(), function(item) {
                idx = this.comments().indexOf(item);
                console.log(idx);
                return idx > l && idx <= r;
            }.bind(this));
        }, this);

        this.loadComments = function loadComments() {
            this.loading(true);
            return Model.get(this.loadCommentsUrl, { limit: this.pageLimit * this.perPage}).done(this.resolveContestComments.bind(this));
        };

        this.resolveContestComments = function resolveContestComments(response) {
            if (response.success === true) {
                this.usersPile = [];
                //this.overload(this.checkingIfTheresMore(response.data));
                this.comments.push.apply(this.comments, ko.utils.arrayMap(response.data, this.mappingCommentsArray.bind(this)));
                if (this.comments().length > 0) {
                    this
                        .downingUsers(this.avatarSize)
                        .then(this.parseUsers.bind(this))
                        .done(this.putUsersInComments.bind(this));
                } else {
                    this.loading(false);
                }
            }
        };

        this.mappingCommentsArray = function mappingCommentsArray(object) {
            var newComment = Object.create(Comment);
            object.comment = newComment.init(object);
            this.pilingUsers(object.authorId);
            return object;
        };

        this.pilingUsers = function pilingUsers(userId) {
            userId = userId;
            if ($.inArray(userId, this.usersPile) === -1) {
                this.usersPile.push(userId);
            }
        };

        this.downingUsers = function downingUsers(avatarSize) {
            return Model.get(User.getUserUrl, { pack: User.createPackList(this.usersPile), avatarSize: avatarSize});
        };

        this.parseUsers = function parseUsers(response) {
            if (response.success === true) {
                this.users = ko.utils.arrayMap(response.data, User.parsePack);
            }
        };

        this.putUsersInComments = function putUsersInComments() {
            this.comments(ko.utils.arrayMap(this.comments(), this.mappingPutUsersInComments.bind(this)));
            this.loading(false);
        };

        this.mappingPutUsersInComments = function mappingPutUsersInComments(object) {
            var st = Model.findById(object.authorId, this.users);
            if (st) {
                object.user = st;
            }
            return object;

        };

        this.loadComments();
    }

    return {
        viewModel: OnAir,
        template: template
    };
});