define(['jquery', 'knockout', 'models/User', 'models/Model', 'models/Status', 'text!post-status-add/post-status-add.html', 'knockout.mapping', 'ko_library'], function postStatusAdd($, ko, User, Model, Status, template) {
    function PostStatusAddViewModel(params) {
        this.user = Object.create(User);
        this.status = Object.create(Status);
        this.load = ko.observable(false);
        this.updateTo = ko.observable(false);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.openMoodsWindow = ko.observable(false);
        this.loadAdd = function loadAdd(paramsInit) {
            if (paramsInit === undefined) {
                this.status.init({});
                this.load(true);
                this.updateTo(false);
            } else {
                this.getStatus(paramsInit.id).done(this.loadAddHandler.bind(this));
                this.updateTo(true);
            }
        };
        this.loadAdd();
        /**
         * getting User
         * @param user
         */
        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
            }
        };
        /**
         * Particular get method
         */
        this.getUser = function getUser() {
            Model
                .get(this.user.getUserUrl, {id: this.user.userId, avatarSize: 72})
                .done(this.userHandler.bind(this));
        };
        this.fetchMoods = function fetchMoods(mood) {
            mood.url = this.status.moodImageUrl + mood.id + '.png';
            return mood;
        };
        this.moodsHandler = function moodsHandler(moods) {
            if (moods.success === true) {
                this.status.moodsArray(ko.utils.arrayMap(moods.data.list, this.fetchMoods.bind(this)));
                this.openMoodsWindow(true);
            }
        };
        this.openMoods = function openMoods() {
            if (this.status.moodsArray().length === 0) {
                Model.get(this.status.moodsUrl).done(this.moodsHandler.bind(this));
            } else {
                this.openMoodsWindow(true);
            }
        };
        this.removeMood = function removeMood() {
            this.status.choosedMood(null);
            this.openMoodsWindow(false);
        };
        this.chooseMood = function chooseMood(mood) {
            this.status.choosedMood(mood);
            this.openMoodsWindow(false);
        };
        this.createStatus = function createStatus() {
            this.status.create().done(function (data) { console.log(data); });
        };
        this.updateStatus = function createStatus() {
            this.status.update().done(function (data) { console.log(data); });
        };
        this.textLength = ko.computed(function computedTextLength() {
            if (this.status.text() !== undefined) {
                return this.status.text().length;
            }
            return 0;
        }, this);
        this.loadAddHandler = function(status) {
            if (status.success === true) {
                this.status.init(status.data);
                this.load(true);
            }
        };
        this.getUser();
    }

    return {
        viewModel: PostStatusAddViewModel,
        template: template
    };
});