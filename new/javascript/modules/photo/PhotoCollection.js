define('photo/PhotoCollection', ['jquery', 'knockout', 'photo/PhotoAttach', 'models/Model', 'extensions/imagesloaded', 'extensions/masonry', 'extensions/PresetManager', 'extensions/isotope', 'extensions/packery'], function PhotoCollectionModel($, ko, PhotoAttach, Model, imagesLoaded, Masonry, PresetManager, Isotope, Packery) {
    "use strict";
    function PhotoCollection(data) {
        this.getAttachesUrl = '/api/photo/collections/getAttaches/';
        this.getNotSortedAttaches = '/api/photo/collections/getByUser/';
        this.pageCount = null;
        this.id = ko.observable(data.id);
        this.attaches = ko.observableArray();
        this.attachesCount = ko.observable(data.attachesCount);
        this.cover = ko.observable();
        this.usablePreset = ko.observable();
        this.updated = ko.observable();
        PresetManager.presets = data.presets;
        this.handlePresets = function gainPhotoInLine(presets) {
            if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                PresetManager.presets = presets;
            }
        };
        this.getCover = function getCover(cover) {
            if (this.attachesCount() > 0) {
                if (!$.isEmptyObject(PresetManager.presets)) {
                    if (cover) {
                        var photoAttach = new PhotoAttach(cover);
                        photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), 'myPhotosAlbumCover'));
                        photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), 'myPhotosAlbumCover'));
                        this.cover(photoAttach);
                    }
                    Model.get(this.getAttachesUrl, {collectionId: this.id(), offset: 0, length: 1})
                        .done(this.handleCover.bind(this));
                } else {
                    $.when(Model.get(this.getAttachesUrl, {
                        collectionId: this.id(),
                        offset: 0,
                        length: 1
                    }), Model.get(PresetManager.getPresetsUrl))
                        .done(this.handleCoverWithPresets.bind(this));
                }
            }
        };
        this.handleCoverWithPresets = function handleCoverWithPresets(photoAttach, presets) {
            photoAttach = photoAttach[0];
            presets = presets[0];
            if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                PresetManager.presets = presets;
            }
            if (photoAttach.success === true && photoAttach.data.attaches.length !== 0) {
                this.cover(new PhotoAttach(photoAttach.data.attaches[0]));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
            }
        };
        this.handleCover = function handleCover(photoAttach) {
            if (photoAttach.success === true && photoAttach.data.attaches.length !== 0) {
                this.cover(new PhotoAttach(photoAttach.data.attaches[0]));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
            }
        };
        this.getCover(data.cover);
        this.getAttachesPage = function getAttachesPage(offset) {
            if (this.attachesCount() > 0) {
                Model
                    .get(this.getAttachesUrl, { collectionId: this.id(), length: this.pageCount, offset: offset })
                    .done(this.getAttaches.bind(this));
            }
        };
        this.getAllAttaches = function getAllAttaches(userId) {
            Model
                .get(this.getNotSortedAttaches, { userId: userId })
                .done(this.getNotSortedAttachesHandler.bind(this));
        };
        this.loadImagesAlg = function loadImagesAlg(instance, image) {
            var attach = Model.findByIdObservable(parseInt(image.img.dataset.id), this.attaches()),
                result;
            if (attach.loading !== undefined) {
                if (image.isLoaded) {
                    attach.loading(false);
                } else {
                    attach
                        .loading(false)
                        .broke(true);
                }
            }
            result = image.isLoaded ? 'loaded' : 'broken';
        };
        this.loadImagesCreation = function loadImagesCreation(event, elemName, container) {
            var imgLoad = imagesLoaded(elemName),
                pckry = new Packery(container, { itemSelector: '.img-grid_i' });
            var imageLoadAlg = this.loadImagesAlg;
            imgLoad.on(event, imageLoadAlg.bind(this));
        };
        this.iterateAttaches = function iterateAttaches(attach) {
            var photoAttach = new PhotoAttach(attach);
            photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), this.usablePreset()));
            photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), this.usablePreset()));
            return photoAttach;
        };
        this.gainPhotoInLine = function gainPhotoInLine(presets) {
            PresetManager.presets = presets;
            if (PresetManager.presets !== undefined) {
                this.attaches(ko.utils.arrayMap(this.attachesCache, this.iterateAttaches.bind(this)));
                if (this.attaches().length > 0) {
                    this.loadImagesCreation('progress', 'photo-album', '#imgs');
                }
            }
        };
        this.getNotSortedAttachesHandler = function getAttaches(attaches) {
            if (attaches.success) {
                this.attachesCache = attaches.data.attaches;
                if ($.isEmptyObject(PresetManager.presets) || PresetManager.presets === undefined) {
                    PresetManager.getPresets(this.gainPhotoInLine.bind(this));
                } else {
                    this.gainPhotoInLine(PresetManager.presets);
                }

            }
        };
        this.getAttaches = function getAttaches(attaches) {
            if (attaches.success) {
                this.attachesCache = attaches.data.attaches;
                if ($.isEmptyObject(PresetManager.presets) || PresetManager.presets === undefined) {
                    PresetManager.getPresets(this.gainPhotoInLine.bind(this));
                } else {
                    this.gainPhotoInLine(PresetManager.presets);
                }

            }
        };
    }

    return PhotoCollection;
});