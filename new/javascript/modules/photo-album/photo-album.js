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
        this.photoAlbum.pageCount = 20;
        this.currentPhoto = ko.observable();
        this.rightsForManipulation = User.checkRights(params.userId);
        this.userId = params.userId;
        this.presets = {};
        this.opened = ko.observable(false);
        /**
         * Reloading images after adding new
         */
        this.reloadImagesAfterAdding = function reloadImagesAfterAdding() {
            this.photoAlbum.photoCollection().loadImagesCreation('progress', 'photo-album', '#imgs');
        };
        /**
         * Resolve presets problems
         * @param collectionPresets
         * @returns {*}
         */
        this.resolvePresets = function resolvePresets(collectionPresets) {
            if (collectionPresets === undefined) {
                return this.presets;
            }
            return collectionPresets;
        };
        /**
         * acceptPresets - function acceprs resolved presets
         *
         * @param  {type} presets description
         * @return {type}         description
         */
        this.acceptPresets = function acceptPresets(imgArray) {
            PresetManager.presets = this.resolvePresets(this.photoAlbum.photoCollection().presets);
            return imgArray;
        };
        /**
         * mappingNewImages - новые изображения при загрузке и подгрузке
         *
         * @param  array imgArray
         * @return array
         */
        this.mappingNewImages = function mappingNewImages(imgArray) {
            for (var i=0; i < imgArray.length; i++) {
                this.photoAlbum.photoCollection().checkUploaded(imgArray[i], this.photoAlbum.photoCount());
                if (imgArray[i].loading() === true) {
                    this.photoAlbum.photoCollection().mappingAttach(imgArray[i], i, this.photoAlbum.usablePreset);
                }
            }
            return imgArray;
        };
        /**
         * new images in album
         * @param val - new array value
         */
        this.figureNewImage = function figureNewImage(val) {
            var dfd = $.Deferred();
            dfd
              .then(this.acceptPresets.bind(this))
              .then(this.mappingNewImages.bind(this))
              .done(this.reloadImagesAfterAdding.bind(this));
            //resolving deffered
            dfd.resolve(val);
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
            if (presets.success === true) {
                this.presets = presets.data;
            }
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
