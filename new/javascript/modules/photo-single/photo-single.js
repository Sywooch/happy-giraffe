define(['jquery', '../knockout', 'text!photo-single/photo-single.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, userConfig, Model, imagesLoaded, customReturner, User) {
    function PhotoSingleViewModel(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbum.pageCount = 5;
        this.loading = ko.observable(true);
        this.photoAlbum.id(params.album);
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = params.userId;
        this.returnNewColor = Model.returnNewColor;
        params.album.presets = params.presets;
        this.removed = ko.observable(false);
        this.opened = ko.observable(false);
        this.gettingAlbum = function gettingAlbum(albums) {
            if (albums.success === true) {
                this.photoAlbum.init(this.photoAlbum.findById(this.photoAlbum.id(), albums.data.albums));
                this.loading(false);
            }
        };
        this.photoAlbum.get(this.userId, true, this.gettingAlbum.bind(this));
        this.remove = function remove() {
            this.photoAlbum.delete();
            this.removed(true);
        };
        this.restore = function restore() {
            this.photoAlbum.restore();
            this.removed(false);
        };
        this.openPhotoHandler = function openPhotoHandler() {
            this.opened(true);
            ko.applyBindings({}, $('photo-slider')[0]);
        };
        this.openPhoto = function openPhoto() {
            return customReturner('photo-slider');
        };
    }
    return { viewModel: PhotoSingleViewModel, template: template };
});