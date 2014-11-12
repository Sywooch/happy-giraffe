define(['jquery', 'knockout', 'modules-helpers/component-custom-returner', 'photo/Photo', 'photo/PhotoAttach', 'common'], function ($, ko, customReturner, Photo, PhotoAttach) {
    // Биндинг для загрузки фото
    ko.bindingHandlers.photoUpload = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = valueAccessor();
            var data = value.data;
            var observable = value.observable;

            var defaultCallback = function (photo) {
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

            var defaultCallback = function(photoInstance) {
                if (observable() instanceof Array) {
                    photoInstance.photo = photoInstance;
                    photoInstance = new PhotoAttach(photoInstance)
                    observable.push(photoInstance);
                } else {
                    observable(photoInstance);
                }
            };

            var callback = value.callback || defaultCallback;

            ko.bindingHandlers.photoComponentUpload.callback = function(photo) {
                callback(photo);
                $.magnificPopup.close();
            };
            $(element).magnificPopup({
                items: {
                    src: customReturner('photo-uploader-form', { initData: JSON.stringify(data) }),
                    type: 'inline'
                }
            });
        }
    };
});