define(['jquery', 'knockout', 'text!signup/login-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner', 'signup/eauth', 'signup/bindings'], function($, ko, template, Form, FormField, Model, customReturner) {
    function LoginForm() {
        var self = this;
        self.submitUrl = '/api/signup/login/';
        self.redirectUrl = '/';
        self.fields = {
            email: new FormField(self, ''),
            password: new FormField(self, ''),
            rememberMe: new FormField(self, false)
        };

        self.submit = function() {
            Model.get(self.submitUrl, { attributes: self.getValues() }).done(function(response) {
                for (var attribute in self.fields) {
                    self.fields[attribute].isFilled(true);
                }
                if (response.success) {
                    document.location.href = self.redirectUrl;
                } else {
                    self.fillErrors(response.data.errors);
                }
            });
        };

        $(".auth-service.vkontakte a").eauth({"popup":{"width":585,"height":350},"id":"vkontakte"});
        $(".auth-service.odnoklassniki a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
    }
    LoginForm.prototype = Object.create(Form);

    LoginForm.prototype.open = function() {
        $.magnificPopup.open({
            items: {
                src: customReturner('login-form'),
                type: 'inline'
            }
        });
        ko.applyBindings({}, $('login-form')[0]);
    };

    return {
        viewModel: LoginForm,
        template: template
    };
});
