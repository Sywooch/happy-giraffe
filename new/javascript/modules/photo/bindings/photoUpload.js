define(['jquery', 'knockout', 'common'], function($, ko) {
    // Биндинг для загрузки фото
    ko.bindingHandlers.photoUpload = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = valueAccessor();
            var data = value.data;
            var observable = value.observable;

            var defaultCallback = function(photo) {
                if (observable() instanceof Array) {
                    observable.push(photo);
                } else {
                    observable(photo);
                }
            }

            var callback = value.callback || defaultCallback;

            ko.bindingHandlers.photoUpload.callback = function(photo) {
                callback(photo);
                $.magnificPopup.close();
            };

            $(element).magnificPopup({
                type: 'ajax',
                ajax: {
                    settings: {
                        url: '/photo/default/uploadForm/',
                        data : data
                    }
                }
            });
        }
    };

    ko.bindingHandlers.photoComponentUpload = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = valueAccessor();
            var data = value.data;
            var observable = value.observable;


            var defaultCallback = function(photo) {
                if (observable() instanceof Array) {
                    observable.push(photo);
                } else {
                    observable(photo);
                }
            };

            var callback = value.callback || defaultCallback;

            ko.bindingHandlers.photoUpload.callback = function(photo) {
                callback(photo);
                $.magnificPopup.close();
            };

            $(element).magnificPopup({
                items: {
                    src: "<photo-uploader-form params='initData: " + JSON.stringify(data) + "'></photo-uploader-form>",
                    type: 'inline'
                }
            });
        }
    };
});