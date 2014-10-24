define(['knockout', 'models/Model'], function PresetManagerHandler(ko, Model) {
    "use strict";
    var PresetManager = {

        getPresetsUrl: '/photo/default/presets/',

        presets: {},

        getPresets: function getPresets(callbackFun) {
            return Model.get(this.getPresetsUrl).done(callbackFun);
        },

        filters: {
            lepilla: {
                getWidth: function getWidth(imageWidth, imageHeight, presetConfig) {
                    var imageRatio = imageWidth / imageHeight,
                        presetRatio = presetConfig.width / presetConfig.height;
                    if (imageRatio >= presetRatio) {
                        return presetConfig.width;
                    } else {
                        return imageRatio * presetConfig.height;
                    }
                },
                getHeight: function getHeight(imageWidth, imageHeight, presetConfig) {
                    return presetConfig.height;
                }
            },
            relativeResize: {
                getWidth: function getWidth(imageWidth, imageHeight, presetConfig) {
                    var imageRatio = presetConfig.parameter / imageHeight;
                    return Math.round(imageWidth * imageRatio);
                },
                getHeight: function getHeight(imageWidth, imageHeight, presetConfig) {
                    if (presetConfig.method === "heighten") {
                        return presetConfig.parameter;
                    }
                    return presetConfig.height;
                }
            }
        },

        getWidth: function getWidth(imageWidth, imageHeight, preset) {
            var config = this.presets[preset];
            return this.filters[config.filter].getWidth(imageWidth, imageHeight, config);
        },

        getHeight: function getHeight(imageWidth, imageHeight, preset) {
            var config = this.presets[preset];
            return this.filters[config.filter].getHeight(imageWidth, imageHeight, config);
        }
    };

    return PresetManager;
});