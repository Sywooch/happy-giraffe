define(['knockout', 'text!photo-albums-create/photo-albums-create.html', 'photo/PhotoAlbum'], function (ko, template, PhotoAlbum) {
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
        this.createAlbumsHandler = function createAlbumsHandler(createData) {

        };
        this.submitCreateFunction = function submitCreateFunction() {
            this.photoAlbum.create(this.createAlbumsHandler.bind(this));
        };
    }
    return { viewModel: PhotoAlbumsCreateViewModel, template: template };
});