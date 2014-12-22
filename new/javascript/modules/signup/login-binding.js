define(['knockout', 'models/User', 'modules-helpers/component-custom-returner', 'kow'], function(ko, User, customReturner) {
    ko.bindingHandlers.login = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                if (User.isGuest) {
                    evt.preventDefault();
                    $.magnificPopup.open({
                        items: {
                            src: customReturner('register-form'),
                            type: 'inline'
                        }
                    });
                    ko.applyBindings({}, $('register-form')[0]);
                }
            });
        }
    };
});