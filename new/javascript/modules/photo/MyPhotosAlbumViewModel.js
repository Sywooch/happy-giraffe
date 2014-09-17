define('photo/MyPhotosAlbumViewModel', ['knockout', 'photo/PhotoAlbum'], function(ko, PhotoAlbum) {
    function MyPhotosAlbumViewModel(data) {
        var self = this;
        self.album = new PhotoAlbum(data.album);

        self.editingHeader = ko.observable(false);
        self.editingDescription = ko.observable(false);

        self.editHeader = function() {
            self.editingHeader(self.album.title());
        };
    }

    return MyPhotosAlbumViewModel;
});