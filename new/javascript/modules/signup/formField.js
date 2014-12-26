define(['knockout'], function FormFieldHandler(ko) {
    function FormField(parent, value) {
        this.validateUrl = '/api/signup/validate/';
        this.isFilled = ko.observable(false);
        this.value = ko.observable(value);
        this.errors = ko.observableArray([]);
        this.fired = ko.observable(false);
        this.firsErrorHandler = function firsErrorHandler() {
            return (this.errors().length > 0) ? this.errors()[0] : null;
        };
        this.firstError = ko.computed(this.firsErrorHandler, this);
        this.cssClassHandler  = function cssClassHandler() {
            if (!this.isFilled()) {
                return '';
            }
            return (this.errors().length > 0) ? 'error' : 'success';
        };
        this.cssClass = ko.computed(this.cssClassHandler, this);

        this.validateParentHanler = function validateParentHanler() {
            this.isFilled(true);
            parent.loading(false);
        };
        this.validate = function validate() {
            if (this.errors.length > 0 || this.fired() === false) {
                parent.validate().done(this.validateParentHanler.bind(this));
            }
            this.fired(true);
        };
    }

    return FormField;
});