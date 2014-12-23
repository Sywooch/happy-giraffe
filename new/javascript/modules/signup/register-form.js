define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/User'], function($, ko, template, User) {
    function Register(params) {
        var self = this;
        self.registerUrl = '/api/signup/register/';

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
    }

    function Form() {
        var self = this;
        self.fields = [];

        self.validate = function(callback) {
            $.post(self.validateUrl, JSON.stringify({ attributes: self.getValues() }), function(response) {


                for (var attribute in self.fields) {
                    if (response.data.errors[attribute] !== undefined) {
                        self.fields[attribute].errors(response.data.errors[attribute]);
                    } else {
                        self.fields[attribute].errors([]);
                    }
                }
                callback(response);
            });
        };

        self.getValues = function() {
            var values = {};
            for (var i in self.fields) {
                values[i] = self.fields[i].value();
            }
            return values;
        };
    }

    function RegisterForm() {
        Form.apply(this, arguments);
        var self = this;
        self.validateUrl = '/api/signup/validate/';
        self.fields = {
            firstName: new FormField(self, 'Никита'),
            lastName: new FormField(self, 'Свистоплясов'),
            birthday: new DateField(self, null),
            gender: new FormField(self, '1'),
            email: new FormField(self, 'nikitafsdf@happy-giraffe.ru'),
            password: new FormField(self, '111111')
        };
    }
    RegisterForm.prototype = Object.create(Form.prototype);

    function CaptchaForm() {
        Form.apply(this, arguments);
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
    CaptchaForm.prototype = Object.create(Form.prototype);

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
        self.value = ko.computed(function() {
            return [self.y(), self.m(), self.d()].join('-');
        });
        self.value.subscribe(function() {
            self.validate();
        });
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
