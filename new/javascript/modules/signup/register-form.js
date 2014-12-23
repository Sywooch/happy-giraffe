define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/Model', 'signup/form', 'signup/formField', 'signup/dateField', 'signup/eauth', 'signup/bindings'], function($, ko, template, Model, Form, FormField, DateField) {
    function Register(params) {
        var self = this;
        self.registerUrl = '/api/signup/register/';
        self.redirectUrl = '/';

        self.SCREEN_STEP_1 = 'screenStep1';
        self.SCREEN_STEP_2 = 'screenStep2';
        self.SCREEN_STEP_SOCIAL = 'screenSocial';



        self.step = ko.observable(self.SCREEN_STEP_1);

        self.registerForm = new RegisterForm();
        self.captchaForm = new CaptchaForm();

        self.registerSimple = function() {
            self.registerForm.validate(function(response) {
                for (var attribute in self.registerForm.fields) {
                    self.registerForm.fields[attribute].isFilled(true);
                }
                if (response.data.errors.length == 0) {
                    self.step(self.SCREEN_STEP_2);
                }
            });
        };

        self.verifyCaptcha = function() {
            self.captchaForm.validate(function(response) {
                for (var attribute in self.captchaForm.fields) {
                    self.captchaForm.fields[attribute].isFilled(true);
                }
                if (response.data.errors.length == 0) {
                    Model.get(self.registerUrl, { attributes: self.registerForm.getValues() }).done(function(response) {
                        if (response.success) {
                            window.location.href = self.redirectUrl;
                        }
                    });
                }
            });
        };

        self.social = function(values) {
            self.registerForm.setValues(values);
            self.step(self.SCREEN_STEP_SOCIAL);
        };

        registerForm = this;
        $(".auth-service.vkontakte a").eauth({"popup":{"width":585,"height":350},"id":"vkontakte"});
        $(".auth-service.odnoklassniki a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
    }

    function RegisterForm() {
        var self = this;
        self.validateUrl = '/api/signup/validate/';
        self.fields = {
            firstName: new FormField(self, '1'),
            lastName: new FormField(self, '2'),
            birthday: new DateField(self, '1990-11-25'),
            gender: new FormField(self, '1'),
            email: new FormField(self, 'nikita+sdfsdf@happy-giraffe.ru'),
            password: new FormField(self, '111111')
        };
    }
    RegisterForm.prototype = Object.create(Form);

    function CaptchaForm() {
        var self = this;
        self.validateUrl = '/api/signup/captcha/';
        self.captchaUrl = '/signup/default/captcha/';

        self.currentCaptchaUrl = ko.observable(self.captchaUrl);

        self.regenerateCaptchaUrl = function() {
            $.get(self.captchaUrl, { refresh: '1'}, function(response) {
                self.currentCaptchaUrl(response.url);
            }, 'json');
        };

        self.fields = {
            verifyCode: new FormField(self, '')
        };
    }
    CaptchaForm.prototype = Object.create(Form);

    return {
        viewModel: Register,
        template: template
    };
});
