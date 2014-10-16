 define('photo/PhotoAttach', ['knockout', 'photo/Photo'], function(ko, Photo) {
    // Основная модель аттача
    function PhotoAttach(data) {
        this.id = ko.observable(data.id);
        this.position = ko.observable(data.position);
        this.photo = ko.observable(new Photo(data.photo));
        this.loading = ko.observable(true);
        this.broke = ko.observable(false);
    }

    return PhotoAttach;
});