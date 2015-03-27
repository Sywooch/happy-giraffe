define(['jquery', 'knockout', 'text!post-photo-add/post-photo-add.html', 'models/Model', 'models/Photopost', 'photo/PhotoCollection', 'ko_photoUpload', 'ko_library'], function ($, ko, template, Model, Photopost, PhotoCollection) {
    function PostPhotoAdd (params) {
        this.photopost = Object.create(Photopost);
        this.load = ko.observable(false);
        this.photoCollection = new PhotoCollection({});
        this.photoIds = ko.observableArray([]);
        this.photopostCover = ko.observable();
        this.cache = {};
        this.gotPhotopost = function gotPhopost(response) {
            if (response.success === true) {
                console.log(response.data);
            }
        };
        if (params.id) {
            this.photopost.get(params.id).done(this.gotPhotopost.bind(this));
        } else {
            this.photopost.init({});
        }
        this.loadPhotoUploader = function loadPhotoUploader() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        this.editPhoto = function editPhoto(data, event) {
            this.cache.title = data.title();
            this.cache.description = data.description();
            data.edit(true);
        };
        this.cancelEditPhoto = function editPhoto(data, event) {
            data.title(this.cache.title);
            data.description(this.cache.description);
            data.edit(false);
        };
        this.doneUpdatingPhoto = function doneUpdatingPhoto(response) {
            if (response.success === true) {
                this.edit(false);
            }
        };
        this.doneEditPhoto = function doneEditPhoto(data, event) {
            data.update().done(this.doneUpdatingPhoto.bind(data));
        };
        this.deletePhoto = function deletePhoto(data, event) {
            var foundObj = Model.findByIdObservableIndex(data.id(), this.photopost.photoArray());
            this.photopost.photoArray.splice(foundObj.index(), 1);
        };
        this.fetchPhotoIds = function fetchPhotoIds(item) {
            if ($.inArray(item.id(), this.photoIds()) === -1) {
                this.photoIds.push(item.id());
            }
        };
        this.titleLength = ko.computed(function computedTitleLength() {
            if (this.load() === true) {
                if (this.photopost.title() !== undefined) {
                    return this.photopost.title().length;
                }
            }
            return 0;
        }, this);
        this.doneCreatingPhotopost = function doneCreatingPhotopost(photopost) {
            if (photopost.success === true) {
                window.location.href = photopost.data.url;
            }
        };
        this.handlePhotoCollection = function handlePhotoCollection(collection) {
            if (collection.success === true) {
                this.photoCollection = new PhotoCollection(collection.data);
                this.photopost.collectionId(this.photoCollection.id());
                console.log(this.photopostCover());
                this.photopost.create().done(this.doneCreatingPhotopost.bind(this));
            }
        };
        this.createPhotoCollection = function () {
            ko.utils.arrayForEach(this.photopost.photoArray(), this.fetchPhotoIds.bind(this));
            if (this.photoIds().length > 0) {
             this.photoCollection.addPhotos(this.photoIds()).done(this.handlePhotoCollection.bind(this));
            }
        };
        this.load(true);
    }

    return {
        viewModel: PostPhotoAdd,
        template: template
    };
});
