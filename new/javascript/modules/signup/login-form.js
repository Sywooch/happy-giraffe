define(['jquery', 'knockout', 'text!signup/login-form.html', 'signup/form', 'signup/formField', 'models/Model', 'modules-helpers/component-custom-returner', 'eauth'], function($, ko, template, Form, FormField, Model, customReturner) {
    function LoginForm() {
        this.submitUrl = '/api/signup/login/';
        this.redirectUrl = '/';
        this.fields = {
            email: new FormField(this, ''),
            password: new FormField(this, ''),
            rememberMe: new FormField(this, false)
        };
        this.vkObj = {
            "popup": {
                "width": 585,
                "height": 350
            },
            "id": "vkontakte"
        };
        this.okObj = {
            "popup":{
                "width": 680,
                "height": 500
            },
            "id": "odnoklassniki"
        };
        this.validateHandler = function validateHandler(response) {
            var attribute;
            for (attribute in this.fields) {
                this.fields[attribute].isFilled(true);
            }
            if (response.success) {
                document.location.href = this.redirectUrl;
            } else {
                this.fillErrors(response.data.errors);
            }
            this.loading(false);
        };
        this.submit = function submit() {
            //Баг в FF
            $("input").trigger("change");
            //Баг в FF
            this.loading(true);
            Model.get(this.submitUrl, { attributes: this.getValues() }).done(this.validateHandler.bind(this));
        };
        $(".auth-service.vkontakte a").eauth(this.vkObj);
        $(".auth-service.odnoklassniki a").eauth(this.okObj);
    }
    LoginForm.prototype = Object.create(Form);

    LoginForm.prototype.open = function open() {
        $.magnificPopup.open({
            items: {
                src: customReturner('login-form'),
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
        ko.applyBindings({}, $('login-form')[0]);
    };

    return {
        viewModel: LoginForm,
        template: template
    };
});
