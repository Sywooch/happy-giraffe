define(['jquery', '../knockout', 'text!photo-single/photo-single.html', 'photo/PhotoAlbum', 'photo/PhotoAttach', 'user-config', 'models/Model', 'extensions/PresetManager', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, PhotoAttach, userConfig, Model, PresetManager, imagesLoaded, customReturner, User) {
    function PhotoSingleViewModel(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbum.pageCount = 3;
        this.getAttachUrl = '/api/photo/attaches/get/';
        this.photoAttach = {};
        this.loading = ko.observable(true);
        this.photoAlbum.id(params.album);
        this.photoAttach.id = ko.observable(params.attach);
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = params.userId;
        this.returnNewColor = Model.returnNewColor;
        this.gettingPresets = function gettingPresets(presets) {
            if (presets) {
                this.presets = presets;
                this.photoAlbum.get(this.userId, true, this.gettingAlbum.bind(this));
            }
        };
        Model
            .get(PresetManager.getPresetsUrl)
            .done(this.gettingPresets.bind(this));
        this.removed = ko.observable(false);
        this.opened = ko.observable(false);
        this.gettingAlbum = function gettingAlbum(albums) {
            if (albums.success === true) {
                this.albums = albums;
                Model.get(this.getAttachUrl, {id: this.photoAttach.id()}).done(this.getAttachesStraight.bind(this));
            }
        };
        this.getAttachesStraight = function getAttachesStraight(attach) {
            if (attach.success === true) {
                this.photoAttach = new PhotoAttach(attach.data);
                this.photoAlbum.offset(this.photoAttach.position() - 1);
                this.photoAlbum.init(this.photoAlbum.findById(this.photoAlbum.id(), this.albums.data.albums));
                PresetManager.presets = this.presets;
                this.photoAttach.photo().presetWidth(PresetManager.getWidth(this.photoAttach.photo().width(), this.photoAttach.photo().height(), "myPhotosAlbumCover"));
                this.photoAttach.photo().presetHeight(PresetManager.getHeight(this.photoAttach.photo().width(), this.photoAttach.photo().height(), "myPhotosAlbumCover"));
                this.loading(false);
            }
        };
        params.album.presets = this.presets;
        this.remove = function remove() {
            this.photoAlbum.delete();
            this.removed(true);
        };
        this.restore = function restore() {
            this.photoAlbum.restore();
            this.removed(false);
        };
        this.next = function next() {
            if (this.photoAlbum.photoCollection().attaches()[2] !== undefined) {
                return this.photoAlbum.photoCollection().attaches()[2].url();
            }
            return false;
        };
        this.prev = function prev() {
            if (this.photoAlbum.photoCollection().attaches()[0].id() <= this.photoAttach.id()) {
                return this.photoAlbum.photoCollection().attaches()[0].url();
            }
            return false;
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