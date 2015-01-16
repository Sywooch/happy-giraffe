define('photo/Photo', ['jquery', 'knockout', 'photo/baseUrlCreator', 'extensions/PresetManager', 'extensions/knockout.validation', 'extensions/validatorRules'], function ($, ko, baseConfig, PresetManager) {
    "use strict";
    // Основная модель фотографии
    function Photo(data) {
        this.id = (ko.isObservable(data.id) === false) ? ko.observable(data.id) : data.id;
        this.title = (ko.isObservable(data.title) === false) ? ko.observable(data.title) : data.title;
        this.description = (ko.isObservable(data.description) === false) ? ko.observable(data.description) : data.description;
        if (this.description() === null) {
            this.description("");
        }
        this.originalname = (ko.isObservable(data.originalname) === false) ? ko.observable(data.originalname) : data.originalname;
        this.width = (ko.isObservable(data.width) === false) ? ko.observable(data.width) : data.width;
        this.preset = (ko.isObservable(data.preset) === false) ? ko.observable(data.preset) : data.preset;
        this.height = (ko.isObservable(data.height) === false) ? ko.observable(data.height) : data.height;
        this.presetWidth = ko.observable();
        this.presetHeight = ko.observable();
        this.presetHash = ko.observable();
        this.edit = ko.observable(false);
        if (data.fsName === undefined) {
            this.fsName = (ko.isObservable(data.fs_name) === false) ? ko.observable(data.fs_name) : data.fs_name;
        } else {
            this.fsName = (ko.isObservable(data.fsName) === false) ? ko.observable(data.fsName) : data.fsName;
        }
        this.originalUrl = (ko.isObservable(data.originalUrl) === false) ? ko.observable(data.originalUrl) : data.originalUrl;
        this.baseConfig = baseConfig;
        this.handlePresets = function handlePresets(data) {
            if (data.success === true) {
                PresetManager.presets = data.data;
                this.presetHash(PresetManager.getPresetHash(this.preset));
            }
        };
        if (data.status !== undefined) {
            this.status = ko.observable(data.status);
        };
        if (data.cropLoaded !== undefined) {
            this.cropLoaded = ko.observable(data.cropLoaded);
        };
        this.getGeneratedPreset = function generatePreseted(preset) {
            if (this.presetHash() === undefined) {
                if (PresetManager.presets === undefined || $.isPlainObject(PresetManager.presets)) {
                    this.preset = preset;
                    PresetManager.getPresets(this.handlePresets.bind(this));
                } else {
                    this.presetHash(PresetManager.getPresetHash(preset));
                }
            } else {
                this.presetHash(PresetManager.getPresetHash(preset));
            }
            return baseConfig + this.presetHash() + '/' + this.fsName();
        };
        this.getGeneratedHeight = function getGeneratedHeight(preset) {
            if (this.presetHeight() === undefined) {
                if (PresetManager.presets === undefined || $.isPlainObject(PresetManager.presets)) {
                    this.preset = preset;
                    PresetManager.getPresets(this.handlePresets.bind(this));
                } else {
                    this.presetHeight(PresetManager.getHeight(this.width(), this.height(), preset));
                }
            }
            return this.presetHeight();
        };
        /**
         * Валидация
         */
        this.maxTitleLength = 40;
        this.maxDescriptionLength = 400;
        this.title.extend({ maxLength: { params: this.maxTitleLength, message: "Количество символов не больше " + this.maxTitleLength }});
        this.description.extend({ maxLength: { params: this.maxDescriptionLength, message: "Количество символов не больше " + this.maxDescriptionLength }});
    }
    return Photo;
});