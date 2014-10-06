define(['knockout'], function(ko) {
    // Биндинг для отображения миниатюр
    ko.bindingHandlers.thumb = {
        update: function (element, valueAccessor) {
            var value = valueAccessor();
            var photo = value.photo;
            var preset = value.preset;

            function update() {
                var src = 'http://img.virtual-giraffe.ru/proxy_public_file/thumbs/' + preset + '/' + photo.fs_name();
                //src = 'http://img2.dev.happy-giraffe.ru/thumbs/' + preset + '/' + photo.fs_name();
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