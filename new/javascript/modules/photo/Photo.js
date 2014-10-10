define('photo/Photo', ['knockout', 'text!photo/baseUrlConfig.json'], function (ko, baseConfigRaw) {
    // Основная модель фотографии
    function Photo(data) {
        this.id = ko.observable(data.id);
        this.title = ko.observable(data.title);
        this.original_name = ko.observable(data.original_name);
        this.width = ko.observable(data.width);
        this.height = ko.observable(data.height);
        this.fs_name = ko.observable(data.fs_name);
        this.originalUrl = ko.observable(data.originalUrl);
        this.baseConfig = JSON.parse(baseConfigRaw);
        this.getGeneratedPreset = function generatePreseted(preset) {
            return this.baseConfig.local + preset + '/' + this.fsName();
        };
    }

    return Photo;
});