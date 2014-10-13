define(['knockout', 'text!photo/baseUrlConfig.json'], function (ko, baseConfigRaw) {
    // Биндинг для отображения миниатюр
    ko.bindingHandlers.thumb = {
        update: function (element, valueAccessor) {
            var value = valueAccessor(),
                photo = value.photo,
                preset = value.preset,
                baseConfig = JSON.parse(baseConfigRaw);

            function update() {
                var src = baseConfig.dev + preset + '/' + photo.fsName();
                //src = baseConfig.server + photo.fsName();
                //src = 'https://test-happygiraffe.s3.amazonaws.com/thumbs/' + preset + '/' + photo.fs_name();
                $(element).attr('src', src);
//                console.log(preset);
//                if (presetManager.filters.hasOwnProperty(preset.filter)) {
//                    $(element).css('width', presetManager.getWidth(photo.width(), photo.height(), preset));
//                    $(element).css('height', presetManager.getHeight(photo.width(), photo.height(), preset));
//                }
            }

            update();

            photo.fs_name.subscribe(function(fs_name) {
                update();
            });
        }
    };
});