define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/Model', 'signup/form', 'signup/formField', 'signup/dateField', 'modules-helpers/component-custom-returner', 'kow', 'signup/eauth', 'ko_library'], function($, ko, template, Model, Form, FormField, DateField, customReturner) {
    function Register() {
        this.redirectUrl = '/';
        this.SCREEN_STEP_1 = 'screenStep1';
        this.SCREEN_STEP_2 = 'screenStep2';
        this.SCREEN_STEP_SOCIAL = 'screenSocial';

        this.step = ko.observable(this.SCREEN_STEP_1);
        this.registerForm = new RegisterForm();
        this.captchaForm = new CaptchaForm();

        this.validateHandler = function validateHandler(response) {
            this.registerForm.setFilled();
            if (response.data.errors.length === 0) {
                this.step(this.SCREEN_STEP_2);
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
            if (response.data.errors.length === 0) {
                this.register();
            }
            this.registerForm.loading(false);
        };

        this.submitSocial = function submitSocial() {
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
            this.step(this.SCREEN_STEP_SOCIAL);
        };

        registerForm = this;
        $(".auth-service.vkontakte a").eauth({"popup":{"width":585,"height":350},"id":"vkontakte"});
        $(".auth-service.odnoklassniki a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
    }

    Register.prototype.open = function openRegister() {
        $.magnificPopup.open({
            items: {
                src: customReturner('register-form'),
                type: 'inline'
            }
        });
        ko.applyBindings({}, $('register-form')[0]);
    };

    function RegisterForm() {
        this.validateUrl = '/api/signup/validate/';
        this.submitUrl = '/api/signup/register/';
        this.fields = {
            firstName: new FormField(this, '1'),
            lastName: new FormField(this, '2'),
            birthday: new DateField(this, '1990-11-25'),
            gender: new FormField(this, '1'),
            email: new FormField(this, 'nikita+sdfsdf@happy-giraffe.ru'),
            password: new FormField(this, '111111'),
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
