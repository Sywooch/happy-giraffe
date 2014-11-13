define('photo/Photo', ['knockout', 'photo/baseUrlCreator', 'extensions/PresetManager'], function (ko, baseConfig, PresetManager) {
    "use strict";
    // Основная модель фотографии
    function Photo(data) {
        this.id = ko.observable(data.id);
        this.title = ko.observable(data.title);
        this.original_name = ko.observable(data.original_name);
        this.width = ko.observable(data.width);
        this.preset = ko.observable();
        this.presetWidth = ko.observable();
        this.presetHeight = ko.observable();
        this.height = ko.observable(data.height);
        this.fsName = ko.observable(data.fsName);
        this.originalUrl = ko.observable(data.originalUrl);
        this.baseConfig = baseConfig;
        this.getGeneratedPreset = function generatePreseted(preset) {
            return baseConfig + preset + '/' + this.fsName();
        };
    }
    return Photo;
});