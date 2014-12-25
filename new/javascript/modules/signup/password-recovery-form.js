define(['knockout', 'text!signup/password-recovery-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner'], function(ko, template, Form, FormField, Model, customReturner) {
    function RecoverForm() {
        this.sent = ko.observable(false);
        this.submitUrl = '/api/signup/passwordRecovery/';
        this.fields = {
            email: new FormField(this, '')
        };
        this.submitHandler = function submitHandler(response) {
            var attribute;
            for (attribute in this.fields) {
                if (this.fields.hasOwnProperty(attribute)) {
                    this.fields[attribute].isFilled(true);
                }
            }
            if (response.success) {
                this.sent(true);
                this.clear();
            } else {
                this.fillErrors(response.data.errors);
            }
        };
        this.submit = function submit() {
            Model.get(this.submitUrl, { attributes: this.getValues() }).done(this.submitHandler.bind(this));
        };
    }
    RecoverForm.prototype = Form;

    RecoverForm.prototype.open = function open() {
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
