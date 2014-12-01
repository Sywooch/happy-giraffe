define(['knockout', 'jquery', 'models/Model'], function PresetManagerHandler(ko, $, Model) {
    var PresetManager = {

        getPresetsUrl: '/api/photo/photos/presets/',

        presets: {},

        getPresets: function getPresets(callbackFun) {
            return Model.get(this.getPresetsUrl).done(callbackFun);
        },

        get: function get() {
            return Model.get(this.getPresetsUrl);
        },

        findPresetConfig: function findPresetConfig(presetName) {
            var index;
            if (presetName) {
                for (index=0; index < this.presets.length; index++) {
                    if ($.inArray(presetName, this.presets[index].usages) !== -1) {
                        return this.presets[index];
                    }
                }
            }
            return false;
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
            var config = this.findPresetConfig(preset);
            return this.filters[config.filter.name].getWidth(imageWidth, imageHeight, config.filter);
        },

        getHeight: function getHeight(imageWidth, imageHeight, preset) {
            var config = this.findPresetConfig(preset);
            return this.filters[config.filter.name].getHeight(imageWidth, imageHeight, config.filter);
        },

        getPresetHash: function getPresetHash(preset) {
            var config = this.findPresetConfig(preset);
            return config.hash;
        }
    };

    return PresetManager;
});