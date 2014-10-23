define(['jquery', 'knockout', 'text!photo-album-compact/photo-album-compact.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, userConfig, Model, imagesLoaded, customReturner) {
    function PhotoAlbumCompact(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbum.pageCount = 5;
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.returnNewColor = Model.returnNewColor;
        params.album.presets = params.presets;
        this.photoAlbum.init(params.album);
        this.opened = ko.observable(false);
        this.photoAlbumUrl = '/photo/user/' + userConfig.userId + '/albums/' + this.photoAlbum.id();
        this.remove = function remove() {
            this.photoAlbum.delete();
        };
        this.restore = function restore() {
            this.photoAlbum.restore();
        };
        this.openPhotoHandler = function openPhotoHandler() {
            this.opened(true);
            ko.applyBindings({}, $('photo-slider')[0]);
        };
        this.openPhoto = function openPhoto() {
            return customReturner('photo-slider');
        };
    }
    return { viewModel: PhotoAlbumCompact, template: template };
});