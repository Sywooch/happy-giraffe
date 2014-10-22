define(['jquery', 'knockout', 'text!photo-albums/photo-albums.html', 'photo/PhotoAlbum', 'user-config', 'extensions/imagesloaded', 'extensions/PresetManager', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, imagesLoaded, PresetManager) {
    function PhotoAlbums() {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbums = ko.observableArray();
        this.loading = ko.observable(true);
        this.newPhotoAlbumUrl = '/photo/user/' + userConfig.userId + '/albums/create/';
        this.handlePresets = function (presets) {
            this.presets = presets;
            this.getAlbums();
        };
        this.getAlbums = function getAlbums() {
            this.photoAlbum.get(userConfig.userId, false, this.fillThePictures.bind(this));
        };
        this.fillThePictures = function fillThePictures(caredData) {
            if (caredData.success === true) {
                caredData.data.presets = PresetManager.presets;
                this.photoAlbums(caredData.data.albums);
                this.loading(false);
            }
        };
        PresetManager.getPresets(this.handlePresets.bind(this));
    }
    return { viewModel: PhotoAlbums, template: template };
});