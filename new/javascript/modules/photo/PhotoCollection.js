define('photo/PhotoCollection', ['jquery', 'knockout', 'photo/PhotoAttach', 'models/Model', 'extensions/imagesloaded', 'extensions/masonry', 'extensions/PresetManager', 'extensions/isotope', 'extensions/packery', 'extensions/waypoints/waypoints'], function PhotoCollectionModel($, ko, PhotoAttach, Model, imagesLoaded, Masonry, PresetManager, Isotope, Packery) {
    "use strict";
    function PhotoCollection(data) {
        this.getCollectionUrl = '/api/photo/collections/get/';
        this.getAttachesUrl = '/api/photo/collections/getAttaches/';
        this.getNotSortedAttaches = '/api/photo/collections/getByUser/';
        this.getAttachUrl = '/api/photo/attaches/get/';
        this.addPhotosUrl = '/api/photo/collections/addPhotos/';
        this.listAttachesUrl = '/api/photo/collections/listAttaches/';
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
        this.isLast = ko.observable(false);
        this.page = ko.observable(0);
        this.pckry = {};
        PresetManager.presets = data.presets;
        /**
         * Handling particular set or presets
         * @param presets
         */
        this.handlePresets = function handlePresets(presets) {
            if (presets.success === true) {
                if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                    PresetManager.presets = presets.data;
                    this.presets = presets.data;
                }
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
                        photoAttach.photo().presetHash(PresetManager.getPresetHash(this.usablePreset()));
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
            if (presets.success === true) {
                if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                    PresetManager.presets = presets.data;
                    this.presets = presets.data;
                }
            }
            if (photoAttach.success === true && photoAttach.data.attaches.length !== 0) {
                this.cover(new PhotoAttach(photoAttach.data.attaches[0]));
                this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                this.cover().photo().presetHash(PresetManager.getPresetHash('myPhotosAlbumCover'));
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
                this.cover().photo().presetHash(PresetManager.getPresetHash('myPhotosAlbumCover'));
                this.loading(false);
            }
        };
        /**
         * Handle cover by id
         * @param photoAttach
         */
        this.handleCoverById = function handleCover(photoAttach) {
            if (photoAttach.success === true) {
                this.cover(new PhotoAttach(photoAttach.data));
                if (PresetManager.presets) {
                    this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                    this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                    this.cover().photo().presetHash(PresetManager.getPresetHash('myPhotosAlbumCover'));
                }
                this.loading(false);
            }
        };
        /**
         * Handle preset without cover
         * @param presets
         */
        this.handlePresetsWOCover = function handleCover(presets) {
            if (presets.success === true) {
                if (presets !== undefined || $.isEmptyObject(PresetManager.presets)) {
                    PresetManager.presets = presets.data;
                    this.presets = presets.data;
                    this.cover().photo().presetWidth(PresetManager.getWidth(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                    this.cover().photo().presetHeight(PresetManager.getHeight(this.cover().photo().width(), this.cover().photo().height(), 'myPhotosAlbumCover'));
                    this.cover().photo().presetHash(PresetManager.getPresetHash('myPhotosAlbumCover'));
                    this.loading(false);
                }
            }

        };
        /**
         * Cover by cover Id
         */
        this.getCoverByCoverId = function getCoverByCoverId(coverId) {
            Model.get(this.getAttachUrl, {
                id: coverId
            }).done(this.handleCoverById.bind(this));
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
        this.getAttachesPage = function getAttachesPage(offset, length, circular) {
            if (this.attachesCount() > 0) {
                this.loading(true);
                Model
                    .get(this.getAttachesUrl, { collectionId: this.id(), length: length || this.pageCount, offset: offset, circular: circular || this.circular })
                    .done(this.getAttaches.bind(this));
            }
        };
        /**
         * list attaches
         */
        this.listAttachesPage = function listAttachesPage(page, pageSize) {
            if (this.attachesCount() > 0) {
                this.loading(true);
                Model
                    .get(this.listAttachesUrl, { collectionId: this.id(), page: page, pageSize: pageSize })
                    .done(this.listAttaches.bind(this));
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
         * handling waypoints event
         */
        this.handlingWaypoints = function handlingWaypoints() {
            if (this.loading() === false && this.isLast() === false) {
                this.page(this.page() + 1);
                this.listAttachesPage(this.page(), 20);
            }
        };
        /**
         * hooking waypoints on element
         */
        this.defferedLoadImagesFunctionHandler = function defferedLoadImagesFunctionHandler() {
            var photoCollection = this,
                hookElement = '.layout-footer',
                offset = '100%';
            var waypoints = $(hookElement).waypoint({
                handler: function handler() {
                    photoCollection.handlingWaypoints();
                },
                offset: offset
            });
        };
        /**
         * hooking events on imagesLoaded object
         * @param imgLoad
         */
        this.imgLoadEventsHook = function imgLoadEventsHook(event, loadingAlgorithm, imgLoad) {
            imgLoad.on(event, loadingAlgorithm.bind(this));
            imgLoad.jqDeferred.then(this.defferedLoadImagesFunctionHandler.bind(this));
        };
        /**
         * Controling loading flow
         * @param event
         * @param elemName
         * @param container
         */
        this.loadImagesCreation = function loadImagesCreation(event, elemName, container) {
            if ($(container).length > 0) {
                this.pckry = new Packery(container, { itemSelector: '.img-grid_i' });
                this.imgLoadEventsHook(event, this.loadImagesAlg, imagesLoaded(elemName));
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
            photoAttach.photo().presetHash(PresetManager.getPresetHash(this.usablePreset()));
            return photoAttach;
        };
        /**
         * Gain in line on photoalbum page
         * @param presets
         */
        this.gainPhotoInLine = function gainPhotoInLine(presets) {
            if (presets.success === true) {
                PresetManager.presets = presets.data;
                this.presets = presets.data;
                if (PresetManager.presets !== undefined) {
                    this.attaches.push.apply(this.attaches, ko.utils.arrayMap(this.attachesCache, this.iterateAttaches.bind(this)));
                    if (this.attaches().length > 0) {
                        this.loadImagesCreation('progress', 'photo-album', '#imgs');
                    }
                }
            } else {
                this.presets = presets;
                if (PresetManager.presets !== undefined) {
                    this.attaches.push.apply(this.attaches, ko.utils.arrayMap(this.attachesCache, this.iterateAttaches.bind(this)));
                    if (this.attaches().length > 0) {
                        this.loadImagesCreation('progress', 'photo-album', '#imgs');
                    }
                }
            }
            this.loading(false);

        };
        /**
         * Получение коллекции для слайдер
         * @param id
         * @param offset
         * @param length
         */
        this.getSliderCollection = function getSliderCollection(id, offset, length) {
            Model
                .when(
                    PresetManager.get(),
                    Model.get(this.getAttachesUrl, { collectionId: id || this.id(), offset: offset, length: length })
                ).done(this.getSliderCollectionHandler.bind(this));
        };
        /**
         * Решить в каком направлении наполнять массив
         * @param oldAttaches
         * @param newAttaches
         * @returns {boolean}
         */
        this.decideToWhatSliderDirection = function decideToWhatSliderDirection(oldAttaches, newAttaches) {
            if (oldAttaches.length > 0) {
                console.log(newAttaches[0].index() < oldAttaches[0].index());
                return newAttaches[0].index() < oldAttaches[0].index();
            }
            return false;
        };
        this.preloadImage = function preloadImage(src) {
            $("<img />").attr("src", src);
        };
        /**
         * iterate slider attaches for the sake of presets handling
         * @param attach
         * @returns {PhotoAttach}
         */
        this.iterateSliderAttaches = function iterateSliderAttaches(attach) {
            var photoAttach = this.iterateAttaches(attach);
            this.preloadImage(photoAttach.photo().getGeneratedPreset(this.usablePreset()));
            return photoAttach;
        };
        /**
         * Манипуляции данными в разрезе формирования линейки фото для слайдера
         * @param presets
         * @param attaches
         */
        this.getSliderCollectionHandler = function getSliderCollectionHandler(presets, attaches) {
            var attachesData = attaches[0],
                presetsData = presets[0],
                direction,
                newAttaches;
            if (attachesData.success && presetsData.success === true) {
                PresetManager.presets = presetsData.data;
                this.presets = presetsData.data;
                if (PresetManager.presets !== undefined) {
                    newAttaches = ko.utils.arrayMap(attachesData.data.attaches, this.iterateSliderAttaches.bind(this));
                    direction = this.decideToWhatSliderDirection(this.attaches(), newAttaches);
                    if (direction) {
                        this.attaches(newAttaches.concat(this.attaches()));
                    } else {
                        this.attaches.push.apply(this.attaches, newAttaches);
                    }
                }
            }
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
                    Model.get(this.getAttachesUrl, { collectionId: id || this.id(), offset: offset, length: length })
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
            if (attachesData.success && presetsData.success === true) {
                PresetManager.presets = presetsData.data;
                this.presets = presetsData.data;
                if (PresetManager.presets !== undefined) {
                    this.attaches(ko.utils.arrayMap(attachesData.data.attaches, this.iterateAttaches.bind(this)));
                }
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
        /**
         * Handle list attaches
         * @param photosIds
         * @returns {$.ajax}
         */
        this.listAttaches = function listAttaches(attaches) {
            if (attaches.success) {
                this.attachesCache = attaches.data.attaches;
                this.isLast(attaches.data.isLast);
                if ($.isEmptyObject(PresetManager.presets) || PresetManager.presets === undefined) {
                    PresetManager.getPresets(this.gainPhotoInLine.bind(this));
                } else {
                    this.gainPhotoInLine(PresetManager.presets);
                }
            }
        };
        /**
         * add photos
         * @param photosIds
         * @returns {$.ajax}
         */
        this.addPhotos = function addPhotos(photosIds) {
            return Model.get(this.addPhotosUrl, { photosIds: photosIds });
        };
        /**
         * get collection by id
         */
        this.get = function get(id) {
            return Model.get(this.getCollectionUrl, { id: id });
        };
        /**
         * increment photo counter
         * @param countOld
         * @param countNew
         * @returns {boolean}
         */
        this.checkUploaded = function incrementPhotoCount(attach, count) {
            if (attach.uploaded() === true) {
                this.attachesCount(count + 1);
            }
        };
        /**
         * mapping attaches
         * @param attach
         * @param index
         */
        this.mappingAttach = function mappingAttach(attach, index, preset) {
            if (attach.photo().presetHeight() === undefined || attach.photo().presetWidth() === undefined) {
                if (this.cover() === undefined && index === 0) {
                    this.cover(attach);
                }
                attach.photo().presetWidth(PresetManager.getWidth(attach.photo().width(), attach.photo().height(), preset));
                attach.photo().presetHeight(PresetManager.getHeight(attach.photo().width(), attach.photo().height(), preset));
            }
        };
    }

    return PhotoCollection;
});