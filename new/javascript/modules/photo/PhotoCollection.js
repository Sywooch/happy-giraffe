define('photo/PhotoCollection', ['jquery', 'knockout', 'photo/PhotoAttach', 'models/Model', 'extensions/imagesloaded', 'extensions/masonry', 'extensions/PresetManager'], function PhotoCollectionModel($, ko, PhotoAttach, Model, imagesLoaded, Masonry, PresetManager) {
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
        this.presetsBound = function iterateAttaches(attach) {
            var photoAttach = new PhotoAttach(attach);
            PresetManager.presets = presets;
            photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
            photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
            return photoAttach;
        };
        this.attachesBound = function (presets) {
            this.attaches(ko.utils.arrayMap(attaches.data, function iterateAttaches(attach) {
                var photoAttach = new PhotoAttach(attach);
                PresetManager.presets = presets;
                photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
                photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
                return photoAttach;
            }.bind(this)));


            //-------- ImagesLoaded
            var imgLoad = imagesLoaded('photo-album');

            new Masonry('#imgs', {
                // options
                itemSelector: '.img-grid_i',
                "isFitWidth": true
            });
            imgLoad.on('progress', function (instance, image) {
                var attach = Model.findByIdObservable(parseInt(image.img.dataset.id), this.attaches());
                if (image.isLoaded) {
                    attach.loading(false);
                } else {
                    attach
                        .loading(false)
                        .broke(true);
                }
                var result = image.isLoaded ? 'loaded' : 'broken';
            }.bind(this));
            //-------- !ImagesLoaded


        };
        this.getAttaches = function getAttaches(attaches) {
            if (attaches.success) {
                PresetManager.getPresets(function (presets) {


                    this.attaches(ko.utils.arrayMap(attaches.data, function iterateAttaches(attach) {
                        var photoAttach = new PhotoAttach(attach);
                        PresetManager.presets = presets;
                        photoAttach.photo().presetWidth(PresetManager.getWidth(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
                        photoAttach.photo().presetHeight(PresetManager.getHeight(photoAttach.photo().width(), photoAttach.photo().height(), "uploadPreviewBig"));
                        return photoAttach;
                    }.bind(this)));


                    //-------- ImagesLoaded
                    var imgLoad = imagesLoaded('photo-album');

                    new Masonry('#imgs', {
                        // options
                        itemSelector: '.img-grid_i',
                        "isFitWidth": true
                    });
                    imgLoad.on('progress', function (instance, image) {
                        var attach = Model.findByIdObservable(parseInt(image.img.dataset.id), this.attaches());
                        if (image.isLoaded) {
                            attach.loading(false);
                        } else {
                            attach
                                .loading(false)
                                .broke(true);
                        }
                        var result = image.isLoaded ? 'loaded' : 'broken';
                    }.bind(this));
                    //-------- !ImagesLoaded


                }.bind(this));
            }
        };

        this.cover = ko.observable(data.cover === null ? null : new PhotoAttach(data.cover));
    }

    return PhotoCollection;
});