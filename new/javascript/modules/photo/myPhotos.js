(function(window) {
    define('photo/myPhotos', ['knockout', 'ko_photo', 'ko_library'], function(ko, ko_photo) {
        return function(data) {
            var self = this;

            self.albums = ko.observableArray(ko.utils.arrayMap(data.albums, function(album) {
                return new ko_photo.PhotoAlbum(album);
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
            }
        }
    });
})(window);