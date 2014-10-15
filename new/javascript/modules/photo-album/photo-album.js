define(['knockout', 'text!photo-album/photo-album.html', 'photo/PhotoAlbum', 'user-config', 'extensions/knockout.validation'], function (ko, template, PhotoAlbum, userConfig) {
    function PhotoAlbumViewModel(params) {
        this.loading = ko.observable(true);
        this.photoAlbum = Object.create(PhotoAlbum);
        this.savingState = {};
        this.getPhotoAlbum = function getPhotoAlbum(passedData) {
            var album;
            if (passedData.success === true) {
                album = this.photoAlbum.findById(params.albumId, passedData.data.albums);
                if (album) {
                    this.photoAlbum = this.photoAlbum.init(album);
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
            this.savingState.title = this.photoAlbum.title();
            this.savingState.description = this.photoAlbum.description();
            this.photoAlbum.editing(true);
        };
        this.successEdit = function () {
            this.photoAlbum.edit(this.editPhotoAlbum.bind(this));
        };
        this.cancelEdit = function () {
            this.photoAlbum.editing(false);
            this.photoAlbum.title(this.savingState.title);
            this.photoAlbum.description(this.savingState.description);
        };
        this.remove = function () {
            this.photoAlbum.delete(this.deletePhotoAlbum.bind(this));
        };
        this.restore = function () {
            this.photoAlbum.restore(this.restorePhotoAlbum.bind(this));
        };
        this.photoAlbum.get(userConfig.userId, false, this.getPhotoAlbum.bind(this));
    }

    return { viewModel: PhotoAlbumViewModel, template: template };
});