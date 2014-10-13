define('photo/PhotoAlbum', ['knockout', 'photo/PhotoCollection'], function(ko, PhotoCollection) {
    // Основная модель фотоальбома
    function PhotoAlbum(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.title = ko.observable(data.title);
        self.description = ko.observable(data.description);
        self.photoCollection = ko.observable(new PhotoCollection(data.photoCollection));

        self.remove = function(callback) {
            $.post('/photo/albums/delete/', { id : self.id() }, function(response) {
                if (response.success) {
                    callback();
                }
            }, 'json');
        }
    }

    return PhotoAlbum;
});