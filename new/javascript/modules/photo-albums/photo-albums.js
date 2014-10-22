define(['jquery', 'knockout', 'text!photo-albums/photo-albums.html', 'photo/PhotoAlbum', 'user-config', 'extensions/imagesloaded', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, imagesLoaded) {
    function PhotoAlbums () {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbums = ko.observableArray();
        this.loading = ko.observable(true);
        this.newPhotoAlbumUrl = '/photo/user/' + userConfig.userId + '/albums/create/';
        this.getAlbums = function getAlbums() {
            this.photoAlbum.get(userConfig.userId, false, this.fillThePictures.bind(this));
        };
        this.fillThePictures = function fillThePictures (caredData) {
            if (caredData.success === true) {
                this.photoAlbums(caredData.data.albums);
                this.loading(false);
            }
        };
        this.getAlbums();
    }
    return { viewModel: PhotoAlbums, template: template };
});