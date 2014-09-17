define(['knockout'], function(ko) {
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
                        url: '/photo/upload/form/',
                        data : data
                    }
                }
            });
        }
    };
});