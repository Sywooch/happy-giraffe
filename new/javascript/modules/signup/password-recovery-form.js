define(['knockout', 'text!signup/password-recovery-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner', 'signup/login-form'], function(ko, template, Form, FormField, Model, customReturner, LoginForm) {
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
                setTimeout(this.openLoginForm.bind(this), 1000);
            } else {
                this.fillErrors(response.data.errors);
            }
            this.loading(false);
        };
        this.openLoginForm = function openLoginForm() {
            LoginForm.viewModel.prototype.open(this.fields.email.value());
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
