define('photo/PresetManager', function() {
    function PresetManager() {
        var self = this;

        self.presets = {"uploadPreview":{"filter":"lepilla","width":155,"height":140},"uploadPreviewBig":{"filter":"lepilla","width":325,"height":295},"uploadAlbumCover":{"filter":"lepilla","width":205,"height":140},"rowGrid":{"filter":"relativeResize","method":"heighten","parameter":200},"myPhotosAlbumCover":{"filter":"lepilla","width":880,"height":580},"myPhotosPreview":{"filter":"relativeResize","method":"heighten","parameter":70}};

        self.filters = {
            lepilla: {
                getWidth: function(imageWidth, imageHeight, presetConfig) {
                    var imageRatio = imageWidth / imageHeight;
                    var presetRatio = presetConfig.width / presetConfig.height;
                    if (imageRatio >= presetRatio) {
                        return presetConfig.width;
                    } else {
                        return imageRatio * presetConfig.height;
                    }
                },
                getHeight: function(imageWidth, imageHeight, presetConfig) {
                    return presetConfig.height;
                }
            }
        }

        self.getWidth = function(imageWidth, imageHeight, preset) {
            var config = self.presets[preset];
            return self.filters[config.filter].getWidth(imageWidth, imageHeight, config);
        }

        self.getHeight = function(imageWidth, imageHeight, preset) {
            var config = self.presets[preset];
            return self.filters[config.filter].getHeight(imageWidth, imageHeight, config);
        }
    }
    presetManager = new PresetManager();
});