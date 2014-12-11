define(['jquery', 'knockout', 'models/User', 'models/Model', 'text!post-status-add/post-status-add.html', 'knockout.mapping'], function postStatusAdd($, ko, User, Model, template) {
    function PostStatusAddViewModel(params) {
        this.user = Object.create(User);
        this.userInstance = ko.mapping.fromJS({});
        /**
         * getting User
         * @param user
         */
        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
                console.log(this.userInstance);
            }
        };
        /**
         * Particular get method
         */
        this.getUser = function getUser() {
            Model
                .get(this.user.getUserUrl, {id: this.userSliderId, avatarSize: 40})
                .done(this.userHandler.bind(this));
        };
        this.getUser();
    }

    return {
        viewModel: PostStatusAddViewModel,
        template: template
    }
});