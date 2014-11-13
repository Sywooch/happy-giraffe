define(['knockout', 'text!photo-albums-create/photo-albums-create.html', 'photo/PhotoAlbum', 'user-config', 'extensions/knockout.validation'], function (ko, template, PhotoAlbum, userConfig) {
    function PhotoAlbumsCreateViewModel(params) {
        this.loading = ko.observable(false);
        this.urlCommon = '/user/' + userConfig.userId + '/albums/';
        /**
         * Checking if editing
         */
        if (params.photoAlbum !== undefined) {
            this.photoAlbum = params.photoAlbum;
            this.savedTitle = this.photoAlbum.title();
            this.savedDescription = this.photoAlbum.description();
        } else {
            this.photoAlbum = Object.create(PhotoAlbum);
        }
        /**
         * Title length computed
         */
        this.titleLength = ko.computed(function computedLength() {
            if (this.photoAlbum.title() !== undefined) {
                return this.photoAlbum.maxTitleLength - this.photoAlbum.title().length;
            }
            return this.photoAlbum.maxTitleLength;
        }, this);
        /**
         * Desc length computed
         */
        this.descriptionLength = ko.computed(function computedLength() {
            if (this.photoAlbum.description() !== undefined) {
                return this.photoAlbum.maxDescriptionLength - this.photoAlbum.description().length;
            }
            return this.photoAlbum.maxDescriptionLength;
        }, this);
        /**
         * Create handler
         * @param createdData
         */
        this.createAlbumsHandler = function createAlbumsHandler(createdData) {
            if (createdData.success === true && createdData.data.id !== undefined) {
                window.location =  this.urlcommon + createdData.data.id + '/';
            }
        };
        /**
         * Cancel editing
         */
        this.cancel = function cancelFn() {
            if (this.photoAlbum.id() !== undefined) {
                this.photoAlbum.title(this.savedTitle);
                this.photoAlbum.description(this.savedDescription);
                this.photoAlbum.editing(false);
            }
        };
        /**
         * Edit handler
         * @param editedData
         */
        this.editAlbumsHandler = function createAlbumsHandler(editedData) {
            if (editedData.success === true && editedData.data.id !== undefined) {
                this.loading(false);
                this.photoAlbum.editing(false);
            }
        };
        /**
         * Submit handler
         */
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