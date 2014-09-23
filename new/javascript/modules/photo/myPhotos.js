(function(window) {
    define('photo/myPhotos', ['knockout', 'photo/PhotoAlbum', 'ko_photoUpload', 'ko_library'], function(ko, PhotoAlbum) {
        return function(data) {
            var self = this;

            self.userId = data.userId;

            self.albums = ko.observableArray(ko.utils.arrayMap(data.albums, function(album) {
                return new PhotoAlbum(album);
            }));

            self.nonEmptyAlbums = ko.computed(function() {
                return ko.utils.arrayFilter(self.albums(), function(album) {
                    return album.photoCollection().attachesCount() > 0;
                });
            });

            self.emptyAlbums = ko.computed(function() {
                return ko.utils.arrayFilter(self.albums(), function(album) {
                    return album.photoCollection().attachesCount() == 0;
                });
            });

            self.removeAlbum = function(album) {
                album.remove(function() {
                    self.albums.remove(album);
                });
            };

            self.init = function() {
                $.post('/api/albums/')
            };

            self.init();
        }
    });
})(window);