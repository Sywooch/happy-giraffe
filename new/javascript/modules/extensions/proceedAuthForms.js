define(['jquery', 'knockout', 'user-config', 'signup/register-form', 'signup/login-form', 'signup/password-recovery-form'], function regLogRemHandler($, ko, userConfig, RegisterForm, LoginForm, PasswordRecoveryForm) {

    var proceedAuthForms = function proceedAuthForms() {
        var buttons = {
                login: {
                    name: 'login-button',
                    vm: LoginForm.viewModel.prototype
                },
                registration: {
                    name: 'registration-button',
                    vm: RegisterForm.viewModel.prototype
                },
                forgot: {
                    name: 'password-recovery-button',
                    vm: PasswordRecoveryForm.viewModel.prototype
                }
            },
            nodes,
            buttonsIter,
            nodesCrawling = function nodesCrawling(element) {
                if (!!ko.dataFor(this)) {
                    ko.cleanNode(this);
                }
                ko.applyBindings(buttons[buttonsIter].vm, this);
            };
        for (buttonsIter in buttons) {
            nodes = $('.' + buttons[buttonsIter].name);
            if (nodes.length > 0) {
                nodes.each(nodesCrawling);
            }
        }
    };

    ko.bindingHandlers.follow = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            if (!viewModel.hasOwnProperty('open')) {
                proceedAuthForms();
            } else {
                $(element).click(function followBindigsClicker(evt) {
                    if (userConfig.isGuest) {
                        evt.preventDefault();
                        viewModel.open();
                        proceedAuthForms();
                    }
                });
            }
        }
    };

    return proceedAuthForms;

});