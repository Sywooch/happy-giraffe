define(['jquery', '../knockout', 'text!photo-single/photo-single.html', 'photo/PhotoAlbum', 'photo/PhotoAttach', 'photo/PhotoCollection', 'user-config', 'models/Model', 'extensions/PresetManager', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, PhotoAttach, PhotoCollection, userConfig, Model, PresetManager, imagesLoaded, customReturner, User) {
    function PhotoSingleViewModel(params) {
        this.getAttachUrl = '/api/photo/attaches/get/';
        this.photoAttach = ko.observable(new PhotoAttach(params.attach));
        this.collectionId = ko.observable(params.collectionId);
        this.photoAttachPrev = params.attachPrev !== false ? new PhotoAttach(params.attachPrev) : false;
        this.photoAttachNext = params.attachNext !== false ? new PhotoAttach(params.attachNext) : false;
        this.loading = ko.observable(true);
        this.photoAttach().id = ko.observable(params.attach);
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = params.userId;
        this.returnNewColor = Model.returnNewColor;
        this.gettingPresets = function gettingPresets(presets) {
            if (presets) {
                this.presets = presets;
                PresetManager.presets = this.presets;
                this.photoAttach().photo().presetWidth(PresetManager.getWidth(this.photoAttach().photo().width(), this.photoAttach().photo().height(), "myPhotosAlbumCover"));
                this.photoAttach().photo().presetHeight(PresetManager.getHeight(this.photoAttach().photo().width(), this.photoAttach().photo().height(), "myPhotosAlbumCover"));
                this.loading(false);
            }
        };
        Model
            .get(PresetManager.getPresetsUrl)
            .done(this.gettingPresets.bind(this));
        this.removed = ko.observable(false);
        this.opened = ko.observable(false);
        this.openPhotoHandler = function openPhotoHandler() {
            this.opened(true);
            //ko.applyBindings({}, $('photo-slider')[0]);
        };
        this.closePhotoHandler = function closePhotoHandler() {
            //ko.cleanNode({}, $('photo-slider')[0]);
            this.opened(false);
        };
        this.loadPhotoComponent = function () {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
    }
    return { viewModel: PhotoSingleViewModel, template: template };
});