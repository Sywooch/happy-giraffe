define('photo/Photo', ['knockout', 'photo/baseUrlCreator', 'extensions/PresetManager'], function (ko, baseConfig, PresetManager) {
    "use strict";
    // Основная модель фотографии
    function Photo(data) {
        this.id = (ko.isObservable(data.id) === false) ? ko.observable(data.id) : data.id;
        this.title = (ko.isObservable(data.title) === false) ? ko.observable(data.title) : data.title;
        this.originalname = (ko.isObservable(data.originalname) === false) ? ko.observable(data.originalname) : data.originalname;
        this.width = (ko.isObservable(data.width) === false) ? ko.observable(data.width) : data.width;
        this.preset = (ko.isObservable(data.preset) === false) ? ko.observable(data.preset) : data.preset;
        this.height = (ko.isObservable(data.height) === false) ? ko.observable(data.height) : data.height;
        this.presetWidth = ko.observable();
        this.presetHeight = ko.observable();
        this.fsName = (ko.isObservable(data.fsName) === false) ? ko.observable(data.fsName) : data.fsName;
        this.originalUrl = (ko.isObservable(data.originalUrl) === false) ? ko.observable(data.originalUrl) : data.originalUrl;
        this.baseConfig = baseConfig;
        this.getGeneratedPreset = function generatePreseted(preset) {
            return baseConfig + preset + '/' + this.fsName();
        };
    }
    return Photo;
});