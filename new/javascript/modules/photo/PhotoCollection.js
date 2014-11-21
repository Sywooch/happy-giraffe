define('photo/PhotoCollection', ['jquery', 'knockout', 'photo/PhotoAttach', 'models/Model', 'extensions/imagesloaded', 'extensions/masonry', 'extensions/PresetManager', 'extensions/isotope', 'extensions/packery'], function PhotoCollectionModel($, ko, PhotoAttach, Model, imagesLoaded, Masonry, PresetManager, Isotope, Packery) {
    "use strict";
    function PhotoCollection(data) {
        this.getAttachesUrl = '/api/photo/collections/getAttaches/';
        this.getNotSortedAttaches = '/api/photo/collections/getByUser/';
        this.getAttachUrl = '/api/photo/attaches/get/';
        this.pageCount = null;
        this.id = ko.observable(data.id);
        this.attaches = ko.observableArray();
        this.attachesCount = ko.observable(data.attachesCount);
        this.cover = ko.observable();
        this.usablePreset = ko.observable();
        this.updated = ko.observable();
        this.loading = ko.observable(true);
        this.circular = ko.observable(false);
        this.presets = data.presets;
        this.pckry = {};
        PresetManager.presets = data.presets;
        /**
         * Handling particular set or presets
         * @param presets
         */
        this.handlePresets = function handlePresets(presets) {
            if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                this.presets = presets;
                PresetManager.presets = presets;
            }
        };
        /**
         * Getting cover of current album
         * @param cover
         */
        this.getCover = function getCover(cover) {
            if (this.attachesCount() > 0) {
                /**
                 * If presets are currently not present
                 */
                if (!$.isEmptyObject(PresetManager.presets)) {
                    if (cover) {
                        var photoAttach = new PhotoAttach(cover);
                        photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), 'myPhotosAlbumCover'));
                        photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), 'myPhotosAlbumCover'));
                        this.cover(photoAttach);
                        this.loading(false);
                    } else {
                        Model.get(this.getAttachesUrl, {collectionId: this.id(), offset: 0, length: 1})
                            .done(this.handleCover.bind(this));
                    }
                } else {
                    if (cover) {
                        this.cover(new PhotoAttach(cover));
                        Model.get(PresetManager.getPresetsUrl)
                            .done(this.handlePresetsWOCover.bind(this));
                    } else {
                        $.when(Model.get(this.getAttachesUrl, {
                            collectionId: this.id(),
                            offset: 0,
                            length: 1
                        }), Model.get(PresetManager.getPresetsUrl))
                            .done(this.handleCoverWithPresets.bind(this));
                    }
                }
            }
        };
        /**
         * Handle cover with particular preset
         * @param photoAttach
         * @param presets
         */
        this.handleCoverWithPresets = function handleCoverWithPresets(photoAttach, presets) {
            photoAttach = photoAttach[0];
            presets = presets[0];
            if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                this.presets = presets;
                PresetManager.presets = presets;
            }
            if (photoAttach.success === true && photoAttach.data.attaches.length !== 0) {
                this.cover(new PhotoAttach(photoAttach.data.attaches[0]));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
            }
            this.loading(false);
        };
        /**
         * Handle cover with old preset
         * @param photoAttach
         */
        this.handleCover = function handleCover(photoAttach) {
            if (photoAttach.success === true && photoAttach.data.attaches.length !== 0) {
                this.cover(new PhotoAttach(photoAttach.data.attaches[0]));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.loading(false);
            }
        };
        /**
         * Handle cover by id
         * @param photoAttach
         */
        this.handleCover = function handleCover(photoAttach) {
            if (photoAttach.success === true) {
                this.cover(new PhotoAttach(photoAttach.data));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.loading(false);
            }
        };
        /**
         * Handle preset without cover
         * @param presets
         */
        this.handlePresetsWOCover = function handleCover(presets) {
            if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                PresetManager.presets = presets;
                this.presets = presets;
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.loading(false);
            }
        };
        /**
         * Cover by cover Id
         */
        this.getCoverByCoverId = function getCoverByCoverId(coverId) {
            Model.get(this.getAttachUrl, {
                id: coverId
            }).done(this.handleCover.bind(this));
        };
        /**
         * Get cover
         */
        if (data.coverId !== undefined) {
            this.getCoverByCoverId(data.coverId);
        } else {
            this.getCover(data.cover);
        }
        /**
         * get page of attaches
         * @param offset
         */
        this.getAttachesPage = function getAttachesPage(offset) {
            if (this.attachesCount() > 0) {
                Model
                    .get(this.getAttachesUrl, { collectionId: this.id(), length: this.pageCount, offset: offset, circular: this.circular })
                    .done(this.getAttaches.bind(this));
            }
        };
        /**
         * get all attaches
         * @param userId
         */
        this.getAllAttaches = function getAllAttaches(userId) {
            Model
                .get(this.getNotSortedAttaches, { userId: userId })
                .done(this.getNotSortedAttachesHandler.bind(this));
        };
        /**
         * Load images in photoalbum algorythm
         * @param instance
         * @param image
         */
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
        /**
         * Load one image in photoalbum algorythm
         * @param instance
         * @param image
         */
        this.loadOne = function loadOne(instance, image) {
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
        /**
         * Controling loading flow
         * @param event
         * @param elemName
         * @param container
         */
        this.loadImagesCreation = function loadImagesCreation(event, elemName, container) {
            if ($(container).length > 0) {
                var imgLoad = imagesLoaded(elemName);
                this.pckry = new Packery(container, { itemSelector: '.img-grid_i' });
                var imageLoadAlg = this.loadImagesAlg;
                imgLoad.on(event, imageLoadAlg.bind(this));
            }
        };
        /**
         * Controling one loading flow
         * @param event
         * @param elemName
         * @param container
         */
         this.loadImage = function loadImage(event, elemName, container) {
             var imgLoad = imagesLoaded(elemName),
                 imageLoadAlg = this.loadOne;
             imgLoad.on(event, imageLoadAlg.bind(this));
         };
        /**
         * iterate attaches for the sake of presets handling
         * @param attach
         * @returns {PhotoAttach}
         */
        this.iterateAttaches = function iterateAttaches(attach) {
            var photoAttach = new PhotoAttach(attach);
            photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), this.usablePreset()));
            photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), this.usablePreset()));
            return photoAttach;
        };
        /**
         * Gain in line on photoalbum page
         * @param presets
         */
        this.gainPhotoInLine = function gainPhotoInLine(presets) {
            PresetManager.presets = presets;
            this.presets = presets;
            if (PresetManager.presets !== undefined) {
                this.attaches(ko.utils.arrayMap(this.attachesCache, this.iterateAttaches.bind(this)));
                if (this.attaches().length > 0) {
                    this.loadImagesCreation('progress', 'photo-album', '#imgs');
                }
            }
        };
        /**
         * Get collection Count
         * @param id
         */
        this.getCollectionCount = function getCollectionCount(id) {
            Model
                .get(this.getAttachesUrl, { collectionId: this.id(), offset: 0 })
                .done(this.countAttaches.bind(this));
        };
        /**
         * get part of current collection
         * @param id
         * @param offset
         * @param length
         */
        this.getPartsCollection = function getPartsCollection(id, offset, length) {
            Model
                .when(
                    PresetManager.get(),
                    Model.get(this.getAttachesUrl, { collectionId: this.id(), offset: offset, length: length })
                )
                .done(this.getPartsCollectionHandler.bind(this));
        };
        /**
         * get part of current collection handler
         * @param id
         * @param offset
         * @param length
         */
        this.getPartsCollectionHandler = function getPartsCollectionHandler(presets, attaches) {
            var attachesData = attaches[0],
                presetsData = presets[0];
            if (attachesData.success && presetsData) {
                PresetManager.presets = presetsData;
                this.presets = presets;
                if (PresetManager.presets !== undefined) {
                    this.attaches(ko.utils.arrayMap(attachesData.data.attaches, this.iterateAttaches.bind(this)));
                }
            }
        };
        /**
         * Count attaches
         * @param attaches
         */
        this.countAttaches = function countAttaches(attaches) {
            if (attaches.success) {
                this.attachesCount(attaches.data.attaches.length);
            }
        };
        /**
         * get all attaches and not sorted at all
         * @param attaches
         */
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
        /**
         *
         * @param attaches
         */
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