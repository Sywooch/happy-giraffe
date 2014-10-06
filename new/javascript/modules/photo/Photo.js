define('photo/Photo', ['knockout'], function(ko) {
    // Основная модель фотографии
    function Photo(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.title = ko.observable(data.title);
        self.original_name = ko.observable(data.original_name);
        self.width = ko.observable(data.width);
        self.height = ko.observable(data.height);
        self.fs_name = ko.observable(data.fs_name);
        self.originalUrl = ko.observable(data.originalUrl);
    }

    return Photo;
});