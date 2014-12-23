define(['text!signup/login-form.html', 'signup/form', 'signup/formField', 'models/Model', 'signup/eauth', 'signup/bindings'], function(template, Form, FormField, Model) {
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
    }
    LoginForm.prototype = Object.create(Form);

    return {
        viewModel: LoginForm,
        template: template
    };
});
