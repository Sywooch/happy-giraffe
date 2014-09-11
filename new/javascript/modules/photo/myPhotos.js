(function(window) {
    define('photo/myPhotos', ['knockout', 'ko_photo', 'ko_library'], function(ko, ko_photo) {
        return function(data) {
            var self = this;

            self.albums = ko.observableArray(ko.utils.arrayMap(data.albums, function(album) {
                return new ko_photo.PhotoAlbum(album);
            }));
        }
    });
})(window);