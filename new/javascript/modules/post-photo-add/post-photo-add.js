define(['jquery', 'knockout', 'text!post-photo-add/post-photo-add.html', 'models/Model', 'models/Photopost', 'photo/PhotoCollection', 'ko_photoUpload', 'ko_library'], function ($, ko, template, Model, Photopost, PhotoCollection) {
    function PostPhotoAdd (params) {
        this.photopost = Object.create(Photopost);
        this.load = ko.observable(false);
        this.photopost.init({});
        this.photoCollection = new PhotoCollection({});
        this.photoIds = ko.observableArray([]);
        this.cache = {};
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
        this.doneEditPhoto = function doneEditPhoto(data, event) {
            data.edit(false);
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
        this.handlePhotoCollection = function handlePhotoCollection(data) {
            if (data.success === true) {
                console.log(data);
            }
        };
        this.createPhotopost = function () {
            ko.utils.arrayForEach(this.photopost.photoArray(), this.fetchPhotoIds.bind(this));
            if (this.photoIds().length > 0) {
             this.photoCollection.addPhotos(this.photoIds()).done(this.handlePhotoCollection.bind(this));
            }
        };
        this.load(true);
    };

    return {
        viewModel: PostPhotoAdd,
        template: template
    };
});