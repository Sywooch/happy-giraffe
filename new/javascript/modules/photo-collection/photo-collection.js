define(['jquery', 'knockout', 'text!photo-collection/photo-collection.html', 'photo/PhotoCollection', 'user-config', 'models/Model', 'extensions/imagesloaded', 'modules-helpers/component-custom-returner', 'models/User', 'extensions/PresetManager', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation'], function ($, ko, template, PhotoCollection, userConfig, Model, imagesLoaded, customReturner, User, PresetManager) {
    function PhotoCollectionView(params) {
        params.attachesCount = 1;
        this.photoCollection = new PhotoCollection(params);
        this.photoCollection.pageCount = 5;
        this.photoCollection.usablePreset('myPhotosPreview');
        this.collectionCount = function collectionCount(count) {
            if (count === undefined) {
                this.photoCollection.getCollectionCount(params.id);
            } else {
                this.photoCollection.attachesCount(count);
            }
        }
        this.handlePresets = function handlePresets(presets) {
            this.photoCollection.getAttachesPage(0);
            this.collectionCount(params.attachCount);
            params.presets = presets;
        };
        PresetManager.getPresets(this.handlePresets.bind(this));
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.returnNewColor = Model.returnNewColor;
        this.opened = ko.observable(false);
    }
    return { viewModel: PhotoCollectionView, template: template };
});