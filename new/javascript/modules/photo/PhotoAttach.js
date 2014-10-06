define('photo/PhotoAttach', ['knockout', 'photo/Photo'], function(ko, Photo) {
    // Основная модель аттача
    function PhotoAttach(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.position = ko.observable(data.position);
        self.photo = ko.observable(new Photo(data.photo));
    }

    return PhotoAttach;
});