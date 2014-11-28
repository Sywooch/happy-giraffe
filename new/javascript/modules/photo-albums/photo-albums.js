define(['jquery', 'knockout', 'text!photo-albums/photo-albums.html', 'photo/PhotoAlbum', 'user-config', 'extensions/imagesloaded', 'extensions/PresetManager', 'models/User', 'models/Model', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, imagesLoaded, PresetManager, User, Model) {
    function PhotoAlbums(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbums = ko.observableArray();
        this.emptyPhotoAlbums = ko.observableArray();
        this.loading = ko.observable(true);
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = params.userId;
        this.newPhotoAlbumUrl = '/user/' + User.userId + '/albums/create/';
        /**
         * handle presets getting
         * @type {string}
         */
        this.handlePresets = function (presets) {
            if (presets.success === true) {
                this.presets = presets.data;
                this.getAlbums();
            }

        };
        /**
         * get albums by user
         */
        this.getAlbums = function getAlbums() {
            if (User.isGuest === true) {
                this.photoAlbum.get(this.userId, true, this.fillThePictures.bind(this));
            } else {
                this.photoAlbum.get(this.userId, false, this.fillThePictures.bind(this));
            }
        };
        /**
         * Reduce albums to the filled
         * @param album
         * @returns {*}
         */
        this.reduceArraysFilled = function (album) {
            if (album.photoCollections.default.attachesCount  !== 0) {
                return album;
            }
        };
        /**
         * Reduce albums to the empty
         * @param album
         * @returns {*}
         */
        this.reduceArraysEmpty = function (album) {
            return album.photoCollections.default.attachesCount  === 0;
        };
        /**
         * remove empty
         * @param arr
         * @returns {*}
         */
        this.removeUnecessaryEmpty = function (arr) {
            var i;
            for (i = arr.length; i--;) {
                if (arr[i].photoCollections.default.attachesCount === 0) {
                    arr.splice(i, 1);
                }
            };
            return arr;
        };
        /**
         * remove filled
         * @param arr
         * @returns {*}
         */
        this.removeUnecessaryFilled = function (arr) {
            var i;
            for (i = arr.length; i--;) {
                if (arr[i].photoCollections.default.attachesCount !== 0) {
                    arr.splice(i, 1);
                }
            };
            return arr;
        };
        /**
         * Fill albums with pictures
         * @param caredData
         */
        this.fillThePictures = function fillThePictures(caredData) {
            var valuesEmpty = caredData.data.albums.slice(0),
                valuesFilled = caredData.data.albums.slice(0);
            if (caredData.success === true) {
                caredData.data.presets = this.presets;
                valuesEmpty = this.removeUnecessaryFilled(valuesEmpty);
                valuesFilled = this.removeUnecessaryEmpty(valuesFilled);
                this.photoAlbums(valuesFilled);
                this.emptyPhotoAlbums(valuesEmpty);
                this.loading(false);
            }
        };
        PresetManager.getPresets(this.handlePresets.bind(this));
    }
    return { viewModel: PhotoAlbums, template: template };
});