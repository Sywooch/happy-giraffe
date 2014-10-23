define(["jquery", "knockout"], function ($, ko) {
    ko.components.register('md-redactor', { require: 'md-redactor/md-redactor' });
    $('md-redactor').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-uploader', { require: 'photo-uploader/photo-uploader' });
    $('photo-uploader').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-uploader-form', { require: 'photo-uploader-form/photo-uploader-form' });
    ko.components.register('photo-albums-create', { require: 'photo-albums-create/photo-albums-create' });
    $('photo-albums-create').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-album', { require: 'photo-album/photo-album' });
    $('photo-album').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-albums', { require: 'photo-albums/photo-albums' });
    $('photo-albums').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-album-compact', { require: 'photo-album-compact/photo-album-compact' });
    $('photo-album-compact').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
    ko.components.register('photo-slider', { require: 'photo-slider/photo-slider' });
    $('photo-slider').each(function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    });
});