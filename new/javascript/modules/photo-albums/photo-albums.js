define(['jquery', 'knockout', 'text!photo-albums/photo-albums.html', 'photo/PhotoAlbum', 'user-config', 'extensions/imagesloaded', 'extensions/PresetManager', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, imagesLoaded, PresetManager, User) {
    function PhotoAlbums(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbums = ko.observableArray();
        this.emptyPhotoAlbums = ko.observableArray();
        this.loading = ko.observable(true);
        this.userId = (User.userId === null) ? params.userId : User.userId;
        this.newPhotoAlbumUrl = '/photo/user/' + User.userId + '/albums/create/';
        this.handlePresets = function (presets) {
            this.presets = presets;
            this.getAlbums();
        };
        this.getAlbums = function getAlbums() {
            if (User.isGuest === true) {
                this.photoAlbum.get(this.userId, true, this.fillThePictures.bind(this));
            }
            else {
                this.photoAlbum.get(this.userId, false, this.fillThePictures.bind(this));
            }
        };
        this.reduceArraysFilled = function (album) {
            if (album.photoCollections.default.attachesCount  !== 0) {
                return album;
            }
        };
        this.reduceArraysEmpty = function (album) {
            return album.photoCollections.default.attachesCount  === 0;
        };
        this.removeUnecessaryEmpty = function (arr) {
            var i;
            for (i = arr.length; i--;) {
                if (arr[i].photoCollections.default.attachesCount === 0) {
                    arr.splice(i, 1);
                }
            };
            return arr;
        };
        this.removeUnecessaryFilled = function (arr) {
            var i;
            for (i = arr.length; i--;) {
                if (arr[i].photoCollections.default.attachesCount !== 0) {
                    arr.splice(i, 1);
                }
            };
            return arr;
        };
        this.fillThePictures = function fillThePictures(caredData) {
            console.log(caredData);
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