define(['knockout', 'models/User', 'modules-helpers/component-custom-returner', 'kow'], function(ko, User, customReturner) {
    ko.bindingHandlers.login = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                if (User.isGuest) {
                    evt.preventDefault();
                    $.magnificPopup.open({
                        items: {
                            src: customReturner('login-form'),
                            type: 'inline'
                        }
                    });
                    ko.applyBindings({}, $('login-form')[0]);
                }
            });
        }
    };

    ko.bindingHandlers.register = {
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

    ko.bindingHandlers.passwordRecovery = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                evt.preventDefault();
                $.magnificPopup.open({
                    items: {
                        src: customReturner('password-recovery-form'),
                        type: 'inline'
                    }
                });
                ko.applyBindings({}, $('password-recovery-form')[0]);
            });
        }
    };
});