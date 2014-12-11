define(['jquery', 'knockout', 'models/User', 'models/Model', 'models/Status', 'text!post-status-add/post-status-add.html', 'knockout.mapping', 'ko_library'], function postStatusAdd($, ko, User, Model, Status, template) {
    function PostStatusAddViewModel(params) {
        this.user = Object.create(User);
        this.status = Object.create(Status);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        /**
         * getting User
         * @param user
         */
        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
                console.log(this.status);
                console.log(this.userInstance);
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
        this.getUser();
    }

    return {
        viewModel: PostStatusAddViewModel,
        template: template
    };
});