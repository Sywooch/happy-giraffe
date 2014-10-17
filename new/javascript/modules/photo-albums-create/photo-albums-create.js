define(['knockout', 'text!photo-albums-create/photo-albums-create.html', 'photo/PhotoAlbum', 'user-config', 'extensions/knockout.validation'], function (ko, template, PhotoAlbum, userConfig) {
    function PhotoAlbumsCreateViewModel(params) {
        this.loading = ko.observable(false);
        if (params.photoAlbum.id() !== undefined) {
            this.photoAlbum = params.photoAlbum;
            this.savedTitle = this.photoAlbum.title();
            this.savedDescription = this.photoAlbum.description();
        } else {
            this.photoAlbum = Object.create(PhotoAlbum);
        }
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
        this.cancel = function cancelFn() {
            if (this.photoAlbum.id() !== undefined) {
                this.photoAlbum.title(this.savedTitle);
                this.photoAlbum.description(this.savedDescription);
                this.photoAlbum.editing(false);
            }
        };
        this.editAlbumsHandler = function createAlbumsHandler(editedData) {
            if (editedData.success === true && editedData.data.id !== undefined) {
                this.loading(false);
                this.photoAlbum.editing(false);
            }
        };
        this.submitCreateFunction = function submitCreateFunction() {
            if (this.photoAlbum.id() !== undefined) {
                this.photoAlbum.edit(this.editAlbumsHandler.bind(this));
            } else {
                this.photoAlbum.create(this.createAlbumsHandler.bind(this));
            }
            this.loading(true);
        };
    }
    return { viewModel: PhotoAlbumsCreateViewModel, template: template };
});