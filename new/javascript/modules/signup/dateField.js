define(['knockout', 'signup/formField'], function(ko, FormField) {
    function DateField(parent, value) {
        FormField.apply(this, arguments);
        this.d = ko.observable();
        this.m = ko.observable();
        this.y = ko.observable();
        this.computedValues = {
            read: function () {
                return [this.y(), this.m(), this.d()].join('-');
            },
            write: function (value) {
                var array = value.split('-');
                this.y(array[0]);
                this.m(array[1]);
                this.d(array[2]);
            }
        };
        this.value = ko.computed(this.computedValues, this);
        this.value(value);
        this.validateDate = function validateDate() {
            this.isFilled(true);
            parent.loading(false);
        };
        this.validate = function validateDate() {
            if (this.d() !== undefined && this.m() !== undefined && this.y() !== undefined) {
                if (this.errors.length > 0 || this.fired() === false) {
                    parent.validate().done(this.validateDate.bind(this));
                }
                this.fired(true);
            }
        };
    }
    DateField.prototype = Object.create(DateField.prototype);

    return DateField;
});