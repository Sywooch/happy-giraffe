define(['jquery', 'knockout', 'text!photo-album/photo-album.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'extensions/imagesloaded', 'models/User',  'extensions/PresetManager', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, userConfig, Model, imagesLoaded, User, PresetManager) {
    "use strict";
    function PhotoAlbumViewModel(params) {
        this.loading = ko.observable(true);
        this.photoAlbum = Object.create(PhotoAlbum);
        this.savingState = {};
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'img-grid_loading img-grid_loading__';
        this.returnNewColor = Model.returnNewColor;
        this.photoAlbum.usablePreset = 'albumList';
        this.photoAlbum.pageCount = null;
        this.currentPhoto = ko.observable();
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = params.userId;
        this.presets = {};
        this.opened = ko.observable(false);
        this.reloadImagesAfterAdding = function reloadImagesAfterAdding() {
            this.photoAlbum.photoCollection().loadImagesCreation('progress', 'photo-album', '#imgs');
        };
        /**
         * new images in album
         * @param val - new array value
         */
        this.figureNewImage = function figureNewImage(val) {
                if (this.photoAlbum.photoCollection().presets === undefined) {
                    PresetManager.presets = this.presets;
                }
                else {
                    PresetManager.presets = this.photoAlbum.photoCollection().presets;
                }
                for (var i=0; i < val.length; i++) {
                    if(val[i].photo().presetHeight() === undefined || val[i].photo().presetWidth() === undefined) {
                        val[i].photo().presetWidth(PresetManager.getWidth(val[i].photo().width(), val[i].photo().height(), this.photoAlbum.usablePreset));
                        val[i].photo().presetHeight(PresetManager.getHeight(val[i].photo().width(), val[i].photo().height(), this.photoAlbum.usablePreset));
                    }
                }
                //!quick for fix for the time being
                setTimeout(this.reloadImagesAfterAdding.bind(this), 1500);
                //!quick for fix for the time being
        };
        /**
         * getting album
         * @param passedData
         */
        this.getPhotoAlbum = function getPhotoAlbum(passedData) {
            var album;
            if (passedData.success === true) {
                album = this.photoAlbum.findById(params.albumId, passedData.data.albums);
                if (album) {
                    this.photoAlbum.init(album);
                    this.loading(false);
                    this.photoAlbum.photoCollection().attaches.subscribe(this.figureNewImage.bind(this));
                }
            }
        };
        /**
         * delete handler
         * @param passedData
         */
        this.deletePhotoAlbum = function deletePhotoAlbum(passedData) {
            if (passedData.success === true) {
                this.photoAlbum.removed(true);
            }
        };
        /**
         * restore handler
         * @param passedData
         */
        this.restorePhotoAlbum = function restorePhotoAlbum(passedData) {
            if (passedData.success === true) {
                this.photoAlbum.removed(false);
            }
        };
        /**
         * edit album meta
         */
        this.editPhotoAlbum = function editPhotoAlbum(passedData) {
            if (passedData.success === true) {
                this.photoAlbum.editing(false);
            }
        };
        /**
         * title length computed
         */
        this.titleLength = ko.pureComputed(function computedLength() {
            if (this.photoAlbum.title() !== undefined) {
                return this.photoAlbum.maxTitleLength - this.photoAlbum.title().length;
            }
            return this.photoAlbum.maxTitleLength;
        }, this);
        /**
         * desc length computed
         */
        this.descriptionLength = ko.pureComputed(function computedLength() {
            if (this.photoAlbum.description() !== undefined) {
                return this.photoAlbum.maxDescriptionLength - this.photoAlbum.description().length;
            }
            return this.photoAlbum.maxDescriptionLength;
        }, this);
        /**
         * edit
         */
        this.edit = function () {
            this.photoAlbum.editing(true);
        };
        /**
         * remove
         */
        this.remove = function () {
            this.photoAlbum.delete(this.deletePhotoAlbum.bind(this));
        };
        /**
         * restore
         */
        this.restore = function () {
            this.photoAlbum.restore(this.restorePhotoAlbum.bind(this));
        };
        /**
         * choosing current photo by click
         */
        this.chooseCurrentPhotoAttach = function chooseCurrentPhotoAttach(photoAttach) {
            this.currentPhoto(photoAttach);
        };
        /**
         * open photo slider
         */
        this.openPhotoHandler = function openPhotoHandler(photoAttach) {
            this.opened(true);
            this.chooseCurrentPhotoAttach(photoAttach);
        };
        /**
        */
        this.setCoverAlbum = function setCoverAlbum(collectionId, cover) {
            this.photoAlbum.photoCollection().cover().isCover(false);
            cover.setCover(collectionId, cover);
            this.photoAlbum.photoCollection().cover(cover);
        };
        /**
         * close photo slider
         */
        this.closePhotoHandler = function closePhotoHandler() {
            this.opened(false);
        };
        this.handlePresets = function handlePresets(presets) {
            this.presets = presets;
        };
        /**
         * Load photo slider
         */
        this.loadPhotoComponent = function () {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            if (this.photoAlbum.photoCollection().presets === undefined) {
                PresetManager.getPresets(this.handlePresets.bind(this));
            }
        };
        this.photoAlbum.get(this.userId, false, this.getPhotoAlbum.bind(this));
    }

    return { viewModel: PhotoAlbumViewModel, template: template };
});