/**
 * joinOrAuthHandler - модуль для того чтобы совершать действия или отправлять на регистрацию. Метод на модели всегда должен называться join, по-крайней мере пока.
 *
 * @return function joinOrAuth
 */
define(['jquery', 'knockout', 'user-config', 'signup/login-form'], function joinOrAuthHandler($, ko, userConfig, LoginForm) {
    var joinOrAuth = function joinOrAuth(button, model) {
        var node = $(button),
        nodesCrawling = function nodesCrawling(element) {
            if (!!ko.dataFor(this)) {
                ko.cleanNode(this);
            }
            ko.applyBindings(model, this);
        };
        if (userConfig.isGuest) {
            model = LoginForm.viewModel.prototype;
        }
        if (node.length > 0) {
            node.each(nodesCrawling);
        }
    };
    ko.bindingHandlers.joinOrAuthBind = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            $(element).click(function followBindigsClicker(evt) {
                evt.preventDefault();
                if (userConfig.isGuest) {
                    viewModel.open();
                } else {
                    viewModel.join();
                }
            });
        }
    };

    return joinOrAuth;
});
