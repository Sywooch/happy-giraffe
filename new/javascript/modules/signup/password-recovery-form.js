define(['knockout', 'text!signup/password-recovery-form.html', 'signup/form', 'signup/formField', 'models/Model', 'signup/bindings'], function(ko, template, Form, FormField, Model) {
    function RecoverForm() {
        var self = this;
        self.sent = ko.observable(false);
        self.submitUrl = '/api/signup/passwordRecovery/';
        self.fields = {
            email: new FormField(self, '')
        };

        self.submit = function() {
            Model.get(self.submitUrl, { attributes: self.getValues() }).done(function(response) {
                for (var attribute in self.fields) {
                    self.fields[attribute].isFilled(true);
                }
                if (response.success) {
                    self.sent(true);
                } else {
                    self.fillErrors(response.data.errors);
                }
            });
        }
    }
    RecoverForm.prototype = Form;

    return {
        viewModel: RecoverForm,
        template: template
    };
});
