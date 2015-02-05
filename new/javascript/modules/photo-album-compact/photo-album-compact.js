define(['jquery', 'knockout', 'text!photo-album-compact/photo-album-compact.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'photo/PhotoAttach', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, userConfig, Model, PhotoAttach, imagesLoaded, customReturner, User) {
    function PhotoAlbumCompact(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbum.pageCount = 5;
        this.currentPhoto = ko.observable();
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = User.checkRights(params.userId);
        this.userId = params.userId;
        this.returnNewColor = Model.returnNewColor;
        params.album.presets = params.presets;
        this.removed = ko.observable(false);
        this.photoAlbum = this.photoAlbum.init(params.album);
        this.opened = ko.observable(false);
        this.userId = params.userId;
        this.limitDescSymbols = 200;
        this.attaches = this.photoAlbum.photoCollection().attaches();
        /**
         * Removing album
         */
        this.remove = function remove() {
            this.photoAlbum.delete();
            this.removed(true);
        };
        /**
         * Adding span tag
         * @param description
         * @returns {*}
         */
        this.checkDescriptionLength = function checkDescriptionLength(description) {
            if (description.length > this.limitDescSymbols) {
                return description.substr(0, this.limitDescSymbols) + ' <span class="ico-more ico-more__white"></span>';
            }
            return description;
        };
        this.photoAlbum.description(this.checkDescriptionLength(this.photoAlbum.description()));
        /**
         * Choosing current attach by click
         * @param photoAttach
         */
        this.chooseCurrentPhotoAttach = function chooseCurrentPhotoAttach(photoAttach) {
            this.currentPhoto(photoAttach);
        };
        /**
         * Restore current album
         */
        this.restore = function restore() {
            this.photoAlbum.restore();
            this.removed(false);
        };
        /**
         * Openening current photo
         * @param photoAttach
         */
        this.openPhotoHandler = function openPhotoHandler(photoAttach) {
            this.opened(true);
            this.chooseCurrentPhotoAttach(photoAttach);
        };
        /**
         * Closing current photo
         */
        this.closePhotoHandler = function closePhotoHandler() {
            this.opened(false);
        };
        this.openPhoto = function openPhoto() {
            return customReturner('photo-slider');
        };
        this.loadPhotoComponent = function () {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            if (this.photoAlbum.photoCollection().presets === undefined) {
                PresetManager.getPresets(this.handlePresets.bind(this));
            }
        };
    }
    return { viewModel: PhotoAlbumCompact, template: template };
});
