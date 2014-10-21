define(['jquery', 'knockout', 'text!photo-album-compact/photo-album-compact.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'extensions/imagesloaded', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, Model, imagesLoaded) {
    function PhotoAlbumCompact(params) {
        this.photoAlbum = Object.create(PhotoAlbum);
        this.photoAlbum.pageCount = 5;
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = ['purple', 'yellow', 'carrot', 'green', 'blue'];
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';
        this.returnNewColor = Model.returnNewColor;
        this.photoAlbum.init(params.album);
    }
    return { viewModel: PhotoAlbumCompact, template: template };
});