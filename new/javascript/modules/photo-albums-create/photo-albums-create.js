define(['knockout', 'text!photo-albums-create/photo-albums-create.html', 'photo/PhotoAlbum', 'user-config', 'extensions/knockout.validation'], function (ko, template, PhotoAlbum, userConfig) {
    function PhotoAlbumsCreateViewModel(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.titleLength = ko.computed(function computedLength() {
            if (this.photoAlbum.title() !== undefined) {
                return this.photoAlbum.maxTitleLength - this.photoAlbum.title().length;
            }
            return this.photoAlbum.maxTitleLength;
        }, this);
        this.descriptionLength = ko.computed(function computedLength() {
            if (this.photoAlbum.description() !== undefined) {
                return this.photoAlbum.maxDescriptionLength - this.photoAlbum.description().length;
            }
            return this.photoAlbum.maxDescriptionLength;
        }, this);
        this.createAlbumsHandler = function createAlbumsHandler(createdData) {
            if (createdData.success === true && createdData.data.id !== undefined) {
                window.location = '/photo/user/' + userConfig.userId + '/albums/' + createdData.data.id + '/';
            }
        };
        this.submitCreateFunction = function submitCreateFunction() {
            this.photoAlbum.create(this.createAlbumsHandler.bind(this));
        };
    }
    return { viewModel: PhotoAlbumsCreateViewModel, template: template };
});