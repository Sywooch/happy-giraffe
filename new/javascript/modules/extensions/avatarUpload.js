define(['jquery', 'knockout', 'modules-helpers/component-custom-returner', 'photo/Photo', 'photo/PhotoAttach', 'common'], function ($, ko, customReturner, Photo, PhotoAttach) {
    ko.bindingHandlers.avatarUpload = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = valueAccessor();
            var data = value.data;
            var observable = value.observable;
            var defaultCallback = function(photoInstance) {
                if (observable() instanceof Array) {
                    // photoInstance.photo = photoInstance;
                    photoInstance = new PhotoAttach(photoInstance);
                    observable.push(photoInstance);
                } else {
                    if (photoInstance.hasOwnProperty('photo')) {
                        observable(new PhotoAttach(photoInstance));
                    }
                    else {
                        observable(photoInstance);
                    }
                }

            };
            var callback = value.callback || defaultCallback;
            ko.bindingHandlers.avatarUpload.callback = function(photo) {
                callback(photo);
                $.magnificPopup.close();
            };
            $(element).magnificPopup({
                items: {
                    src: customReturner('avatar-uploader', { initData: JSON.stringify(data) }),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {
                        ko.applyBindings({}, $('avatar-uploader')[0]);
                    }
                }
            });
        }
    };
    ko.applyBindings({}, document.getElementById('avatar-upload'));
});




