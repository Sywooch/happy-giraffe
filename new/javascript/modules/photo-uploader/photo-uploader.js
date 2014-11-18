define(['jquery', 'knockout', 'text!photo-uploader/photo-uploader.html', 'ko_photoUpload'], function photoUploaderHandler($, ko, template) {
    function PhotoUploaderView(params) {
        this.photo = params.photoInstance;
        this.photos = ko.observableArray([]);

    }
    return {
        viewModel: PhotoUploaderView,
        template: template
    };
});