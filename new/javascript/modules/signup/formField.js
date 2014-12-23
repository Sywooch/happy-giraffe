define(['knockout'], function(ko) {
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
        };
    }

    return FormField;
});