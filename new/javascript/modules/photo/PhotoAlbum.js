define('photo/PhotoAlbum', ['knockout', 'photo/PhotoCollection', 'models/Model', 'extensions/knockout.validation', 'extensions/validatorRules'], function(ko, PhotoCollection, Model) {
    var PhotoAlbum = {
        createUrl: '/api/photo/albums/create/',
        deleteUrl: '/api/photo/albums/remove/',
        restoreUrl: '/api/photo/albums/restore/',
        editUrl: '/api/photo/albums/edit/',
        getByUser: '/api/photo/albums/getByUser/',
        id: ko.observable(),
        url: '',
        editing: ko.observable(false),
        photoCollection: ko.observable(),
        maxTitleLength: 100,
        maxDescriptionLength: 450,
        title: ko.observable(),
        description: ko.observable(),
        removed: ko.observable(false),
        offset: ko.observable(0),
        circular: ko.observable(0),
        pageCount: 20,
        type: 'full',
        usablePreset: '',
        /**
         * Create album
         * @param callback
         */
        create: function createPhotoAlbum(callback) {
            var objCreate = {};
            objCreate.attributes = {};
            objCreate.attributes.title = this.title();
            if (this.description() !== undefined && this.description() !== "") {
                objCreate.attributes.description = this.description();
            }
            Model
                .get(this.createUrl, objCreate)
                .done(callback);
        },
        /**
         * Find album by id
         * @param id
         * @param albums
         * @returns {*}
         */
        findById: function findById(id, albums) {
            var albumIterator;
            for (albumIterator = 0; albumIterator < albums.length; albumIterator++) {
                if (id === albums[albumIterator].id) {
                    return albums[albumIterator];
                }
            }
            return false;
        },
        /**
         * Get album by user
         * @param userId
         * @param empty
         * @param callback
         */
        get: function getByUserPhotoAlbum(userId, empty, callback) {
            Model
                .get(this.getByUser, { userId: userId, notEmpty: empty })
                .done(callback);
        },
        /**
         * Delete current album
         * @param callback
         */
        delete: function deletePhotoAlbum(callback) {
            Model
                .get(this.deleteUrl, { id : this.id() })
                .done(callback);
        },
        /**
         * Restore current album
         * @param callback
         */
        restore: function restorePhotoAlbum(callback) {
            Model
                .get(this.restoreUrl, { id : this.id() })
                .done(callback);
        },
        /**
         * Edit current album meta
         * @param callback
         */
        edit: function deletePhotoAlbum(callback) {
            var objCreate = {};
            objCreate.id = this.id();
            objCreate.attributes = {};
            objCreate.attributes.title = this.title();
            objCreate.attributes.description = this.description();
            Model
                .get(this.editUrl, objCreate)
                .done(callback);
        },
        /**
         * Init album
         * @param data
         */
        init: function initPhotoAlbum(data) {
            this.id = ko.observable(data.id);
            this.title = ko.observable(data.title);
            this.updated = ko.observable(data.updated);
            this.url = data.url;
            this.description = ko.observable(data.description);
            if (data.photoCollections !== undefined) {
                data.photoCollections.default.presets = data.presets;
                this.photoCollection = ko.observable(new PhotoCollection(data.photoCollections.default));
                this.photoCollection().pageCount = this.pageCount;
                this.photoCollection().usablePreset(this.usablePreset);
                this.photoCollection().updated(data.photoCollections.default.updated);
                this.photoCollection().circular = this.circular();
                this.photoCollection().listAttachesPage(this.photoCollection().page(), this.pageCount);
            }
            this.title.extend({ maxLength: { params: this.maxTitleLength, message: "Количество символов не больше " + this.maxTitleLength }, mustFill: true });
            this.description.extend({ maxLength: { params: this.maxDescriptionLength, message: "Количество символов не больше " + this.maxDescriptionLength } });
            this.editing = ko.observable(false);
            this.photoCount = ko.computed(function photoCount() {
                if (this.photoCollection() !== undefined) {
                    return this.photoCollection().attachesCount();
                }
            }, this);
            return this;
        }
    };
    PhotoAlbum.title.extend({ maxLength: { params: PhotoAlbum.maxTitleLength, message: "Количество символов не больше " + PhotoAlbum.maxTitleLength }, mustFill: true });
    PhotoAlbum.description.extend({ maxLength: { params: PhotoAlbum.maxDescriptionLength, message: "Количество символов не больше " + PhotoAlbum.maxDescriptionLength } });

    return PhotoAlbum;
});