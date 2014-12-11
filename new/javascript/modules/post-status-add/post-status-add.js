define(['jquery', 'knockout', 'models/User', 'models/Model', 'models/Status', 'text!post-status-add/post-status-add.html', 'knockout.mapping', 'ko_library'], function postStatusAdd($, ko, User, Model, Status, template) {
    function PostStatusAddViewModel(params) {
        this.user = Object.create(User);
        this.status = Object.create(Status);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.openMoodsWindow = ko.observable(false);
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

        this.getUser();
    }

    return {
        viewModel: PostStatusAddViewModel,
        template: template
    };
});