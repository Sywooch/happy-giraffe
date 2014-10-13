define('photo/PhotoAlbum', ['knockout', 'photo/PhotoCollection', 'models/Model'], function(ko, PhotoCollection, Model) {
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


    ko.extenders.required = function requiredHandler(target, overrideMessage) {
        //define a function to do validation
        function validate(newValue) {
            if (target.hasError() !== true) {
                if (newValue.trim() === '') {
                    target.hasError(true);
                    target.validationMessage(overrideMessage || "Это поле обязательное");
                } else {
                    target.hasError(false);
                }
            }
        }
        //validate whenever the value changes
        target.subscribe(validate);
        //return the original observable
        return target;
    };

    ko.extenders.morethan = function morethanHandler(target, max) {
        //define a function to do validation
        function validate(newValue) {
            if (target.hasError() !== true) {
                if (newValue.length > max) {
                    target.hasError(true);
                    target.validationMessage("Максимальное число символов " + max);
                } else {
                    target.hasError(false);
                }
            }
        }
        //validate whenever the value changes
        target.subscribe(validate);
        //return the original observable
        return target;
    };

    var PhotoAlbum = {
        createUrl: '/api/photo/albums/create',
        deleteUrl: '/api/photo/albums/delete',
        id: ko.observable(),
        photoCollection: ko.observable(),
        maxTitleLength: 150,
        maxDescriptionLength: 450,
        title: ko.observable(),
        description: ko.observable(),
        create: function createPhotoAlbum(callback) {
            Model
                .get(this.createUrl, { id : this.id() })
                .done(callback);
        },
        delete: function deletePhotoAlbum(callback) {
            Model
                .get(this.deleteUrl, { id : this.id() })
                .done(callback);
        },
        init: function initPhotoAlbum(data) {
            this.id = ko.observable(data.id);
            this.title = ko.observable(data.title);
            this.description = ko.observable(data.description);
            this.photoCollection = ko.observable(new PhotoCollection(data.photoCollection));
        }
    };
    PhotoAlbum.title.hasError = ko.observable(false);
    PhotoAlbum.title.validationMessage = ko.observable('');
    PhotoAlbum.description.hasError = ko.observable(false);
    PhotoAlbum.description.validationMessage = ko.observable('');
    PhotoAlbum.title.extend({ required: "Введите название альбома", morethan: PhotoAlbum.maxTitleLength });
    PhotoAlbum.description.extend({ morethan: PhotoAlbum.maxDescriptionLength });

    return PhotoAlbum;
});