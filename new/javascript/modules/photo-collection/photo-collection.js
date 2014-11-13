define(['jquery', 'knockout', 'text!photo-collection/photo-collection.html', 'photo/PhotoCollection', 'user-config', 'models/Model', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'extensions/PresetManager', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoCollection, userConfig, Model, imagesLoaded, customReturner, User, PresetManager) {
    function PhotoCollectionView(params) {
        console.log(params);
        params.attachesCount = 1;
        this.photoCollection = new PhotoCollection(params);
        this.photoCollection.pageCount = 5;
        this.photoCollection.usablePreset('myPhotosPreview');
        this.opened = ko.observable(false);
        this.currentPhoto = ko.observable();
        /**
         * Count handler
         * @param count
         */
        this.collectionCount = function collectionCount(count) {
            if (count === undefined) {
                this.photoCollection.getCollectionCount(params.id);
            } else {
                this.photoCollection.attachesCount(count);
            }
        };
        /**
         * handler presets getting
         * @param presets
         */
        this.handlePresets = function handlePresets(presets) {
            this.photoCollection.getAttachesPage(0);
            this.collectionCount(params.attachCount);
            params.presets = presets;
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
        /**
         * Choosing current attach by click
         * @param photoAttach
         */
        this.chooseCurrentPhotoAttach = function chooseCurrentPhotoAttach(photoAttach) {
            this.currentPhoto(photoAttach);
        };
        PresetManager.getPresets(this.handlePresets.bind(this));
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.returnNewColor = Model.returnNewColor;
        this.opened = ko.observable(false);
    }
    return { viewModel: PhotoCollectionView, template: template };
});