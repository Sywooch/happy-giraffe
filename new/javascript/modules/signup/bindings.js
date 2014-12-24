define(['knockout', 'models/User', 'signup/register-form', 'signup/login-form', 'signup/password-recovery-form', 'kow'], function(ko, User, RegisterForm, LoginForm, PasswordRecoveryForm) {
    ko.bindingHandlers.login = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                if (User.isGuest) {
                    evt.preventDefault();
                    LoginForm.viewModel.prototype.open();
                }
            });
        }
    };

    ko.bindingHandlers.register = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                if (User.isGuest) {
                    evt.preventDefault();
                    RegisterForm.viewModel.prototype.open();
                }
            });
        }
    };

    ko.bindingHandlers.passwordRecovery = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function (evt) {
                evt.preventDefault();
                PasswordRecoveryForm.viewModel.prototype.open();
            });
        }
    };
});