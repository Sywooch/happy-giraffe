define(['jquery', 'knockout', 'text!photo-uploader/photo-uploader.html', 'ko_photoUpload'], function photoUploaderHandler($, ko, template) {
    function PhotoUploaderView() {
        this.photo = ko.observable(null);
        this.photos = ko.observableArray([]);
        this.loadPhotoComponent = function () {
            $('photo-uploader-form').each(function componentIterator() {
                ko.applyBindings({}, $(this)[0]);
            });
        };
    }
    return {
        viewModel: PhotoUploaderView,
        template: template
    };
});