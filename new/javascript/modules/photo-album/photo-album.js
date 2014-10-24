define(['jquery', 'knockout', 'text!photo-album/photo-album.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'extensions/imagesloaded', 'models/User', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoAlbum, userConfig, Model, imagesLoaded, User) {
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
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.userId = (User.userId === null) ? params.userId : User.userId;
        this.getPhotoAlbum = function getPhotoAlbum(passedData) {
            var album;
            if (passedData.success === true) {
                album = this.photoAlbum.findById(params.albumId, passedData.data.albums);
                if (album) {
                    this.photoAlbum.init(album);
                    this.loading(false);
                }
            }
        };
        this.deletePhotoAlbum = function deletePhotoAlbum(passedData) {
            if (passedData.success === true) {
            }
        };
        this.restorePhotoAlbum = function restorePhotoAlbum(passedData) {
            if (passedData.success === true) {
            }
        };
        this.editPhotoAlbum = function editPhotoAlbum(passedData) {
            if (passedData.success === true) {
                this.photoAlbum.editing(false);
            }
        };
        this.titleLength = ko.pureComputed(function computedLength() {
            if (this.photoAlbum.title() !== undefined) {
                return this.photoAlbum.maxTitleLength - this.photoAlbum.title().length;
            }
            return this.photoAlbum.maxTitleLength;
        }, this);
        this.descriptionLength = ko.pureComputed(function computedLength() {
            if (this.photoAlbum.description() !== undefined) {
                return this.photoAlbum.maxDescriptionLength - this.photoAlbum.description().length;
            }
            return this.photoAlbum.maxDescriptionLength;
        }, this);
        this.edit = function () {
            this.photoAlbum.editing(true);
        };
        this.remove = function () {
            this.photoAlbum.delete(this.deletePhotoAlbum.bind(this));
        };
        this.restore = function () {
            this.photoAlbum.restore(this.restorePhotoAlbum.bind(this));
        };
        this.loadPhotoComponent = function () {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        this.photoAlbum.get(this.userId, false, this.getPhotoAlbum.bind(this));
    }

    return { viewModel: PhotoAlbumViewModel, template: template };
});