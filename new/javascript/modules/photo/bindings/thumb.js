define(['knockout',  'photo/baseUrlCreator', 'photo/Photo'], function (ko, baseConfig, Photo) {
    // Биндинг для отображения миниатюр
    ko.bindingHandlers.thumb = {
        update: function (element, valueAccessor) {
            var value = valueAccessor(),
                photo = new Photo(value.photo),
                preset = value.preset;
            photo.preset = preset;
            function update() {
                var src = photo.getGeneratedPreset(photo.preset);
                $(element).attr('src', src);
            }
            update();
            photo.fsName.subscribe(function (fsName) {
                update();
            });
        }
    };
});