define(['knockout',  'photo/baseUrlCreator'], function (ko, baseConfig) {
    // Биндинг для отображения миниатюр
    ko.bindingHandlers.thumb = {
        update: function (element, valueAccessor) {
            var value = valueAccessor(),
                photo = value.photo,
                preset = value.preset;

            function update() {
                var src = baseConfig + preset + '/' + photo.fsName();
                $(element).attr('src', src);
            }
            update();
            photo.fsName.subscribe(function (fsName) {
                update();
            });
        }
    };
});