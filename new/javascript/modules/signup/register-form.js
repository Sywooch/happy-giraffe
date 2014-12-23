define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/User', 'signup/eauth'], function($, ko, template, User) {
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
                if (response.data.errors.length == 0) {
                    self.step(self.SCREEN_STEP_2);
                    console.log('1');
                }
                console.log('2');
            });
        };

        self.verifyCaptcha = function() {
            $.post(self.registerUrl, JSON.stringify({ attributes: self.registerForm.getValues() }), function(response) {
                if (response.success) {
                    window.location.href = self.redirectUrl;
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

    var Form = {
        validate: function(callback) {
            $.post(this.validateUrl, JSON.stringify({ attributes: this.getValues() }), function(response) {
                for (var attribute in this.fields) {
                    if (response.data.errors[attribute] !== undefined) {
                        this.fields[attribute].errors(response.data.errors[attribute]);
                    } else {
                        this.fields[attribute].errors([]);
                    }
                }
                callback(response);
            });
        },
        getValues: function() {
            var values = {};
            for (var i in this.fields) {
                values[i] = this.fields[i].value();
            }
            return values;
        },
        setValues: function(values) {
            for (var key in values) {
                if (this.fields.hasOwnProperty(key)) {
                    this.fields[key].value(values[key]);
                }
            }
        }
    };

    function RegisterForm() {
        var self = this;
        self.validateUrl = '/api/signup/validate/';
        self.fields = {
            firstName: new FormField(self, ''),
            lastName: new FormField(self, ''),
            birthday: new DateField(self, null),
            gender: new FormField(self, ''),
            email: new FormField(self, ''),
            password: new FormField(self, '')
        };
    }
    RegisterForm.prototype = Object.create(Form);

    function CaptchaForm() {
        var self = this;
        self.validateUrl = '/api/signup/captcha/';
        self._captchaUrl = '/signup/default/captcha/';

        self.captchaUrl = function() {
            return self._captchaUrl + '?' + Math.floor((Math.random() * 1000000) + 1);
        };

        self.fields = {
            verifyCode: new FormField(self, '')
        };
    }
    CaptchaForm.prototype = Object.create(Form);

    function FormField(parent, value) {
        var self = this;
        self.validateUrl = '/api/signup/validate/';
        self.isFilled = ko.observable(false);
        self.value = ko.observable(value);
        self.errors = ko.observableArray([]);
        self.firstError = ko.computed(function() {
            return (self.errors().length > 0) ? self.errors()[0] : null;
        });
        self.cssClass = ko.computed(function() {
            if (! self.isFilled()) {
                return '';
            }
            return (self.errors().length > 0) ? 'error' : 'success';
        });
        self.validate = function() {
            console.log(parent);
            parent.validate(function() {
                self.isFilled(true);
            });
        };
        self.value.subscribe(function() {
            self.validate();
        });
    }

    function DateField(parent, value) {
        FormField.apply(this, arguments);
        var self = this;
        self.d = ko.observable();
        self.m = ko.observable();
        self.y = ko.observable();
        self.d.subscribe(function() {
            self.updateValue();
        });
        self.m.subscribe(function() {
            self.updateValue();
        });
        self.y.subscribe(function() {
            self.updateValue();
        });
        self.updateValue = function() {
            self.value([self.y(), self.m(), self.d()].join('-'));
        };
        self.validate = function() {
            if (self.d() !== undefined && self.m() !== undefined && self.y() !== undefined) {
                parent.validate(function() {
                    self.isFilled(true);
                });
            }
        };
    }
    DateField.prototype = Object.create(DateField.prototype);

    return {
        viewModel: Register,
        template: template
    };
});
