define(['register-form', 'user-config'], function(RegisterForm, userConfig) {
    ko.bindingHandlers.login = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function() {
                if (userConfig.isGuest) {
                    alert('123');
                }
                return false;
            });
        },
        update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            // This will be called once when the binding is first applied to an element,
            // and again whenever any observables/computeds that are accessed change
            // Update the DOM element based on the supplied values here.
        }
    };
});