define('photo/MyPhotosAlbumViewModel', ['knockout', 'photo/PhotoAlbum'], function(ko, PhotoAlbum) {
    function MyPhotosAlbumViewModel(data) {
        var self = this;
        self.album = new Album(data.album);

        self.editingHeader = ko.observable(false);
        self.editingDescription = ko.observable(false);

        self.editHeader = function() {
            self.editingHeader(self.album.title());
        };

        self.removeAlbum = function() {
            self.album.remove(function() {
                document.location.href = data.returnUrl;
            });
        };
    }

    function Album(data) {
        var self = this;
        PhotoAlbum.apply(self, arguments);
    }

    return MyPhotosAlbumViewModel;
});