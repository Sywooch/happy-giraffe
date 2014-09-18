define('photo/MyPhotosAlbumViewModel', ['knockout', 'photo/PhotoAlbum', 'ko_photoUpload'], function(ko, PhotoAlbum) {
    function MyPhotosAlbumViewModel(data) {
        var self = this;
        self.MODE_SIMPLE = 0;
        self.MODE_SORT = 1;
        self.MODE_MOVE = 2;

        self.mode = ko.observable(self.MODE_SIMPLE);

        self.sort = function() {
            self.mode(self.MODE_SORT);
        }

        self.album = new Album(data.album);

        self.editingTitle = ko.observable(false);
        self.editingDescription = ko.observable(false);

        self.editTitle = function() {
            self.editingTitle(self.album.title());
        };

        self.editDescription = function() {
            self.editingDescription(self.album.description());
        };

        self.saveTitle = function() {

        }

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