define('photo/PhotoAlbum', ['knockout', 'photo/PhotoCollection', 'models/Model', 'extensions/knockout.validation'], function(ko, PhotoCollection, Model) {
    // Основная модель фотоальбома
    //function PhotoAlbum(data) {
    //    this.id = ko.observable(data.id);
    //    this.title = ko.observable(data.title);
    //    this.description = ko.observable(data.description);
    //    this.photoCollection = ko.observable(new PhotoCollection(data.photoCollection));
    //
    //    this.createUrl =
    //
    //    this.remove = function removePhotoAlbum(callback) {
    //        Model
    //            .get('/photo/albums/delete/', { id : this.id() })
    //            .done(callback);
    //    };
    //
    //    this.create = function createPhotoAlbum(callback) {
    //        Model
    //            .get('/photo/albums/delete/', { id : this.id() })
    //            .done(callback);
    //
    //    };
    //}


    ko.validation.configure({
        registerExtenders: true,
        messagesOnModified: true
    });
    ko.validation.rules.mustFill = {
        validator: function (val, bool) {
            if (val !== undefined) {
                if (bool && val.trim() !== '') {
                    return true;
                }
                return false;
            }
        },
        message: 'Это обязательное поле'
    };
    ko.validation.registerExtenders();

    var PhotoAlbum = {
        createUrl: '/api/photo/albums/create/',
        deleteUrl: '/api/photo/albums/remove/',
        restoreUrl: '/api/photo/albums/restore/',
        editUrl: '/api/photo/albums/edit/',
        getByUser: '/api/photo/albums/getByUser/',
        id: ko.observable(),
        editing: ko.observable(),
        photoCollection: ko.observable(),
        maxTitleLength: 150,
        maxDescriptionLength: 450,
        title: ko.observable(),
        description: ko.observable(),
        removed: ko.observable(false),
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
        findById: function findById(id, albums) {
            var albumIterator;
            for (albumIterator = 0; albumIterator < albums.length; albumIterator++) {
                if (id === albums[albumIterator].id) {
                    return albums[albumIterator];
                }
            }
            return false;
        },
        get: function getByUserPhotoAlbum(userId, empty, callback) {
            Model
                .get(this.getByUser, { userId: userId, notEmpty: empty })
                .done(callback);
        },
        delete: function deletePhotoAlbum(callback) {
            Model
                .get(this.deleteUrl, { id : this.id() })
                .done(callback);
            this.removed(true);
        },
        restore: function restorePhotoAlbum(callback) {
            Model
                .get(this.restoreUrl, { id : this.id() })
                .done(callback);
            this.removed(false);
        },
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
        init: function initPhotoAlbum(data) {
            this.id = ko.observable(data.id);
            this.title = ko.observable(data.title);
            this.description = ko.observable(data.description);
            if (data.photoCollections !== undefined) {
                this.photoCollection = ko.observable(new PhotoCollection(data.photoCollections.default));
            }
            this.title.extend({ maxLength: { params: this.maxTitleLength, message: "Количество символов не больше" + this.maxTitleLength }, mustFill: true });
            this.description.extend({ maxLength: { params: this.maxDescriptionLength, message: "Количество символов не больше" + this.maxDescriptionLength } });
            this.editing = ko.observable(false);
            this.photoCount = ko.computed(function photoCount() {
                if (this.photoCollection() !== undefined) {
                    return this.photoCollection().attachesCount();
                }
            }, this);
            return this;
        }
    };
    PhotoAlbum.title.extend({ maxLength: { params: PhotoAlbum.maxTitleLength, message: "Количество символов не больше" + PhotoAlbum.maxTitleLength }, mustFill: true });
    PhotoAlbum.description.extend({ maxLength: { params: PhotoAlbum.maxDescriptionLength, message: "Количество символов не больше" + PhotoAlbum.maxDescriptionLength } });

    return PhotoAlbum;
});