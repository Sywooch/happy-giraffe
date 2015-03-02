define(['jquery', 'knockout', 'user-config', 'signup/login-form'], function joinOrAuthHandler($, ko, userConfig, LoginForm) {
    ko.bindingHandlers.joinOrAuth = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function followBindigsClicker(evt) {
                if (userConfig.isGuest) {
                    evt.preventDefault();
                    LoginForm.viewModel.prototype.open();
                }
            });
        }
    };

    return proceedAuthForms;
});
