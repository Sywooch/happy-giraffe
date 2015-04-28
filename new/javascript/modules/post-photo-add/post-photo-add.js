define(['jquery', 'knockout', 'text!post-photo-add/post-photo-add.html', 'models/Model', 'models/Photopost', 'photo/PhotoCollection', 'ko_photoUpload', 'ko_library'], function ($, ko, template, Model, Photopost, PhotoCollection) {
    function PostPhotoAdd (params) {
        this.photopost = Object.create(Photopost);
        this.load = ko.observable(false);
        this.photoCollection = new PhotoCollection({});
        this.photoCollection.usablePreset('uploadPreview');
        this.photoIds = ko.observableArray([]);
        this.photopostCover = ko.observable();
        this.cache = {};
        this.gotCollection = function gotCollection(response) {
            if (response.success === true) {
                this.photoCollection.cover(response.data.cover);
                this.photopostCover(response.data.cover.id.toString());
                this.photoCollection.getPartsCollection(this.photopost.collectionId(), 0, null);
            }
        };
        this.gotPhotopost = function gotPhopost(response) {
            if (response.success === true) {
                this.photopost.init(response.data);
                this.photoCollection.id(this.photopost.collectionId());
                this.photoCollection.get(this.photopost.collectionId()).done(this.gotCollection.bind(this));
                this.load(true);
            }
        };
        if (params.id) {
            this.photopost.get(params.id).done(this.gotPhotopost.bind(this));
        } else {
            this.photopost.init({});
            this.load(true);
        }
        this.photopostCover.subscribe(function photopostCoverChangingHandler(newCover) {
            if (this.photoCollection.id()) {
                this.photoCollection.setCover(parseInt(newCover));
            }
        }.bind(this));
        this.loadPhotoUploader = function loadPhotoUploader() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        this.editPhoto = function editPhoto(data, event) {
            if (data.hasOwnProperty('photo')) {
                this.cache.title = data.photo().title();
                this.cache.description = data.photo().description();
                data.photo().edit(true);
            } else {
                this.cache.title = data.title();
                this.cache.description = data.description();
                data.edit(true);
            }
        };
        this.cancelEditPhoto = function editPhoto(data, event) {
            if (data.hasOwnProperty('photo')) {
                data.photo().title(this.cache.title);
                data.photo().description(this.cache.description);
                data.photo().edit(false);
            } else {
                data.title(this.cache.title);
                data.description(this.cache.description);
                data.edit(false);
            }
        };
        this.doneUpdatingPhoto = function doneUpdatingPhoto(response) {
            if (response.success === true) {
                this.edit(false);
            }
        };
        this.doneEditPhoto = function doneEditPhoto(data, event) {
            if (data.hasOwnProperty('photo')) {
                data.photo().update().done(this.doneUpdatingPhoto.bind(data.photo()));
            } else {
                data.update().done(this.doneUpdatingPhoto.bind(data));
            }
        };
        this.deletePhoto = function deletePhoto(data, event) {
            var foundObj;
            if (data.hasOwnProperty('photo')) {
                foundObj = Model.findByIdObservableIndex(data.id(), this.photoCollection.attaches());
                this.photoCollection.attaches.splice(foundObj.index(), 1);
                data.remove();
            } else {
                foundObj = Model.findByIdObservableIndex(data.id(), this.photopost.photoArray());
                this.photopost.photoArray.splice(foundObj.index(), 1);
            }
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
        this.coverForNewCollection = function coverForNewCollection(response) {
            if (response.success === true) {
                for (var i = 0; i < response.data.attaches.length; i++) {
                    if (response.data.attaches[i].photo.id === parseInt(this.photopostCover())) {
                        this.photopostCover(response.data.attaches[i].id.toString());
                        this.photoCollection.setCover(parseInt(this.photopostCover())).done(this.startCreating.bind(this));
                    }
                }
            }
        };
        this.handlePhotoCollection = function handlePhotoCollection(collection) {
            if (collection.success === true) {
                this.photoCollection = new PhotoCollection(collection.data);
                this.photopost.collectionId(this.photoCollection.id());
                if (this.photopostCover()) {
                    this.photoCollection.getPartsCollectionModel(this.photopost.collectionId(), 0, null).done(this.coverForNewCollection.bind(this));
                } else {
                    this.photopost.create().done(this.doneCreatingPhotopost.bind(this));
                }
            }
        };
        this.startCreating = function startCreating() {
            this.photopost.create().done(this.doneCreatingPhotopost.bind(this));
        };
        this.updatePhotoPost = function updatePhotoPost() {
            this.photopost.update().done(this.doneCreatingPhotopost.bind(this));
        };
        this.createPhotoCollection = function createPhotoCollection() {
            ko.utils.arrayForEach(this.photopost.photoArray(), this.fetchPhotoIds.bind(this));
            if (this.photoIds().length > 0) {
             this.photoCollection.addPhotos(this.photoIds()).done(this.handlePhotoCollection.bind(this));
            }
        };
    }

    return {
        viewModel: PostPhotoAdd,
        template: template
    };
});
