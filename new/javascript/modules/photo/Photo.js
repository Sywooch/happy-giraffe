define('photo/Photo', ['knockout', 'photo/baseUrlCreator'], function (ko, baseConfig) {
    // Основная модель фотографии
    function Photo(data) {
        this.id = ko.observable(data.id);
        this.title = ko.observable(data.title);
        this.original_name = ko.observable(data.original_name);
        this.width = ko.observable(data.width);
        this.height = ko.observable(data.height);
        this.fs_name = ko.observable(data.fs_name);
        this.originalUrl = ko.observable(data.originalUrl);
        this.getGeneratedPreset = function generatePreseted(preset) {
            return baseConfig + preset + '/' + this.fsName();
        };
    }

    return Photo;
});