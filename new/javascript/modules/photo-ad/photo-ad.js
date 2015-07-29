define(['jquery', 'knockout', 'text!photo-ad/photo-ad.html', 'photo/PhotoCollection', 'models/Model', 'models/User'], function($, ko, template, PhotoCollection, Model, User) {
    function PhotoAd(params) {
        this.post = params.post;
        this.collection = new PhotoCollection(params.collection);

        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.user = Object.create(User);

        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
            }
        };
        this.getUser = function getUser() {
            Model
                .get(this.user.getUserUrl, {id: this.post.authorId, avatarSize: 72})
                .done(this.userHandler.bind(this));
        };

        this.getUser();
    }

    return {
        viewModel: PhotoAd,
        template: template
    };
});