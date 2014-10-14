define(['knockout', 'text!photo-album/photo-album.html', 'photo/PhotoAlbum', 'user-config', 'extensions/knockout.validation'], function (ko, template, PhotoAlbum, userConfig) {
    function PhotoAlbumViewModel(params) {
        this.loading = ko.observable(true);
        this.photoAlbum = Object.create(PhotoAlbum);
        this.getPhotoAlbum = function getPhotoAlbum(passedData) {
            var album;
            if (passedData.success === true) {
                album = this.photoAlbum.findById(params.albumId, passedData.data.albums);
                if (album) {
                    this.photoAlbum = this.photoAlbum.init(album);
                    this.loading(false);
                }
            }
        };
        this.titleLength = ko.pureComputed(function computedLength() {
            console.log('qwe');
            if (this.photoAlbum.title() !== undefined) {
                return this.photoAlbum.maxTitleLength - this.photoAlbum.title().length;
            }
            return this.photoAlbum.maxTitleLength;
        }, this);
        this.descriptionLength = ko.pureComputed(function computedLength() {
            console.log('qwe');
            if (this.photoAlbum.description() !== undefined) {
                return this.photoAlbum.maxDescriptionLength - this.photoAlbum.description().length;
            }
            return this.photoAlbum.maxDescriptionLength;
        }, this);
        this.photoAlbum.get(userConfig.userId, false, this.getPhotoAlbum.bind(this));
    }

    return { viewModel: PhotoAlbumViewModel, template: template };
});