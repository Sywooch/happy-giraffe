define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/Model', 'signup/form', 'signup/formField', 'signup/dateField', 'modules-helpers/component-custom-returner', 'kow', 'signup/eauth', 'ko_library'], function($, ko, template, Model, Form, FormField, DateField, customReturner) {
    function Register() {
        this.redirectUrl = '/';
        this.SCREEN_STEP_1 = 'screenStep1';
        this.SCREEN_STEP_2 = 'screenStep2';
        this.SCREEN_STEP_SOCIAL = 'screenSocial';
        this.checkRegisterForm = function checkRegisterForm(RegisterForm) {
            if (typeof(RegisterForm) === 'object') {
                RegisterForm.step(this.registerForm.SCREEN_STEP_SOCIAL);
                return RegisterForm;
            }
            return new RegisterForm();
        };
        this.registerForm = this.checkRegisterForm(RegisterForm);
        this.step = this.registerForm.step;
        this.captchaForm = new CaptchaForm();
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
            this.registerForm.setFilled();
            if (response.data.errors.length === 0) {
                this.registerForm.step(this.SCREEN_STEP_2);
            }
            this.registerForm.loading(false);
        };

        this.submitSimple = function submitSimple() {
            this.registerForm.validate().done(this.validateHandler.bind(this));
        };

        this.validateCaptchaForm = function validateCaptchaForm(response) {
            this.captchaForm.setFilled();
            if (response.data.errors.length === 0) {
                this.register();
            }
            this.registerForm.loading(false);
        };
        this.submitCaptcha = function submitCaptcha() {
            this.captchaForm.validate().done(this.validateCaptchaForm.bind(this));
        };

        this.validateSocialHandler = function validateSocialHandler(response) {
            this.registerForm.setFilled();
            if (response.data.errors.length === 0) {
                this.register();
            }
            this.registerForm.loading(false);
        };

        this.submitSocial = function submitSocial() {
            console.log('submitted');
            this.registerForm.validate().done(this.validateSocialHandler.bind(this));
        };

        this.registerFormSubmitHandler = function registerFormSubmitHandler(response) {
            if (response.success) {
                window.location.href = response.data.returnUrl;
            }
        };

        this.register = function register(response) {
            this.registerForm.submit(this.registerFormSubmitHandler.bind(this));
        };

        this.social = function social(values) {
            this.registerForm.setValues(values);
            this.registerForm.step(this.registerForm.SCREEN_STEP_SOCIAL);
        };
        registerForm = this;
        $(".auth-service.vkontakte a").eauth(this.vkObj);
        $(".auth-service.odnoklassniki a").eauth(this.okObj);
    }

    Register.prototype.open = function openRegister(model) {
        $.magnificPopup.open({
            items: {
                src: customReturner('register-form'),
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
        if (model !== undefined) {
            RegisterForm = model.registerForm;
            ko.applyBindings(Register, $('register-form')[0]);
        } else {
            ko.applyBindings({}, $('register-form')[0]);
        }
    };

    function RegisterForm() {
        this.validateUrl = '/api/signup/validate/';
        this.submitUrl = '/api/signup/register/';
        this.SCREEN_STEP_1 = 'screenStep1';
        this.SCREEN_STEP_2 = 'screenStep2';
        this.SCREEN_STEP_SOCIAL = 'screenSocial';
        this.step = ko.observable(this.SCREEN_STEP_1);
        this.validateHandler = function validateHandler(response) {
            this.setFilled();
            if (response.data.errors.length === 0) {
                this.step(this.SCREEN_STEP_2);
            }
            this.loading(false);
        };
        this.fields = {
            firstName: new FormField(this, ''),
            lastName: new FormField(this, ''),
            birthday: new DateField(this, ''),
            gender: new FormField(this, ''),
            email: new FormField(this, ''),
            password: new FormField(this, ''),
            avatarSrc: new FormField(this, null)
        };
    }
    RegisterForm.prototype = Object.create(Form);

    function CaptchaForm() {
        this.validateUrl = '/api/signup/captcha/';
        this.captchaUrl = '/signup/default/captcha/';

        this.currentCaptchaUrl = ko.observable(this.captchaUrl);

        this.regenerateCaptchaUrlHandler = function regenerateCaptchaUrlHandler(response) {
            this.currentCaptchaUrl(response.url);
        };
        this.regenerateCaptchaUrl = function regenerateCaptchaUrl() {
            $.get(this.captchaUrl, { refresh: '1'}, this.regenerateCaptchaUrlHandler.bind(this), 'json');
        };

        this.fields = {
            verifyCode: new FormField(this, '')
        };
    }
    CaptchaForm.prototype = Object.create(Form);

    return {
        viewModel: Register,
        template: template
    };
});
