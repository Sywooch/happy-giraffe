define(['knockout', 'text!signup/password-recovery-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner', 'signup/bindings'], function(ko, template, Form, FormField, Model, customReturner) {
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
                    self.clear();
                } else {
                    self.fillErrors(response.data.errors);
                }
            });
        }
    }
    RecoverForm.prototype = Form;

    RecoverForm.prototype.open = function() {
        $.magnificPopup.open({
            items: {
                src: customReturner('password-recovery-form'),
                type: 'inline'
            }
        });
        ko.applyBindings({}, $('password-recovery-form')[0]);
    };

    return {
        viewModel: RecoverForm,
        template: template
    };
});
