define('photo/PhotoCollection', ['jquery', 'knockout', 'photo/PhotoAttach', 'models/Model', 'extensions/imagesloaded', 'extensions/masonry', 'extensions/PresetManager', 'extensions/isotope'], function PhotoCollectionModel($, ko, PhotoAttach, Model, imagesLoaded, Masonry, PresetManager, Isotope) {
    "use strict";
    // Основная модель коллекции
    function PhotoCollection(data) {
        this.getAttachesUrl = '/api/photo/collections/getAttaches/';
        this.pageCount = 20;
        this.id = ko.observable(data.id);
        this.attaches = ko.observableArray();
        this.attachesCount = ko.observable(data.attachesCount);
        this.getAttachesPage = function getAttachesPage(offset) {
            Model
                .get(this.getAttachesUrl, { collectionId: this.id(), length: this.pageCount, offset: offset })
                .done(this.getAttaches.bind(this));
        };
        this.loadImagesAlg = function loadImagesAlg(instance, image) {
            var attach = Model.findByIdObservable(parseInt(image.img.dataset.id), this.attaches());
            if (attach.loading !== undefined) {
                if (image.isLoaded) {
                    attach.loading(false);
                } else {
                    attach
                        .loading(false)
                        .broke(true);
                }
            }
            var result = image.isLoaded ? 'loaded' : 'broken';
        };
        this.loadImagesCreation = function (event, elemName, container) {
            var imgLoad = imagesLoaded(elemName),
                iso = new Isotope(container, {layoutMode: 'fitRows'}),
                imageLoadAlg = this.loadImagesAlg;
            imgLoad.on(event, imageLoadAlg.bind(this));
        };
        this.iterateAttaches = function iterateAttaches(attach) {
            var photoAttach = new PhotoAttach(attach);
            photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
            photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
            return photoAttach;
        };
        this.gainPhotoInLine = function (presets) {
            if (presets !== undefined) {
                PresetManager.presets = presets;
                this.attaches(ko.utils.arrayMap(this.attachesCache, this.iterateAttaches.bind(this)));
                if (this.attaches().length > 0) {
                    this.loadImagesCreation('progress', 'photo-album', '#imgs');
                }
            }
        };
        this.getAttaches = function getAttaches(attaches) {
            if (attaches.success) {
                this.attachesCache = attaches.data.attaches;
                PresetManager.getPresets(this.gainPhotoInLine.bind(this));
            }
        };

        this.cover = ko.observable(data.cover === null ? null : new PhotoAttach(data.cover));
    }

    return PhotoCollection;
});