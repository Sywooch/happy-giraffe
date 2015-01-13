define(['knockout', 'text!signup/password-recovery-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner'], function(ko, template, Form, FormField, Model, customReturner) {
    function RecoverForm() {
        this.sent = ko.observable(false);
        this.submitUrl = '/api/signup/passwordRecovery/';
        this.fields = {
            email: new FormField(this, '')
        };
        this.validateHandler = function validateHandler(response) {
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
            this.loading(false);
        };
        this.submit = function submit() {
            this.loading(true);
            Model.get(this.submitUrl, { attributes: this.getValues() }).done(this.validateHandler.bind(this));
        };
    }
    RecoverForm.prototype = Form;

    RecoverForm.prototype.open = function open() {
        $.magnificPopup.open({
            items: {
                src: customReturner('password-recovery-form'),
                type: 'inline',
                overflowY: 'auto',
                tClose: 'Закрыть',
                fixedBgPos: true,
                callbacks: {
                    open: function() {
                        $('html').addClass('mfp-html');
                        addBaron('.scroll');
                    },
                    close: function() {
                        $('html').removeClass('mfp-html');
                    }
                }
            }
        });
        ko.applyBindings({}, $('password-recovery-form')[0]);
    };

    return {
        viewModel: RecoverForm,
        template: template
    };
});
