define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/User'], function($, ko, template, User) {
    function RegisterForm(params) {
        var self = this;
        self.validateUrl = '/api/signup/validate/';

        self.fields = {
            firstName: new FormField(self, ''),
            lastName: new FormField(self, '')
        };

        self.validate = function(callback) {
            $.post(self.validateUrl, JSON.stringify({ attributes: self.getValues() }), function(response) {
                for (var attribute in self.fields) {
                    if (response.data.errors[attribute] !== undefined) {
                        self.fields[attribute].errors(response.data.errors[attribute]);
                    } else {
                        self.fields[attribute].errors([]);
                    }
                }
                console.log(callback);
                callback();
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
            parent.validate(function() {
                self.isFilled(true);
            });
        }
    }

    return {
        viewModel: RegisterForm,
        template: template
    };
});
