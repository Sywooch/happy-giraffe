define(['jquery', 'knockout', 'text!post-photo-add/post-photo-add.html', 'models/Photopost', 'ko_photoUpload'], function ($, ko, template, Photopost) {
    function PostPhotoAdd (params) {
        this.photopost = Object.create(Photopost);
        this.load = ko.observable(false);
        this.photopost.init({});
        this.titleLength = ko.computed(function computedTitleLength() {
            if (this.load() === true) {
                if (this.photopost.title() !== undefined) {
                    return this.photopost.title().length;
                }
            }
            return 0;
        }, this);
        this.load(true);
    };

    return {
        viewModel: PostPhotoAdd,
        template: template
    };
});