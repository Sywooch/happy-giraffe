define(['knockout', 'signup/formField'], function(ko, FormField) {
    function DateField(parent, value) {
        FormField.apply(this, arguments);
        var self = this;
        self.d = ko.observable();
        self.m = ko.observable();
        self.y = ko.observable();
        self.value = ko.computed({
            read: function () {
                return [self.y(), self.m(), self.d()].join('-');
            },
            write: function (value) {
                var array = value.split('-');
                self.y(array[0]);
                self.m(array[1]);
                self.d(array[2]);
            }
        });
        self.value(value);
        self.validate = function() {
            if (self.d() !== undefined && self.m() !== undefined && self.y() !== undefined) {
                parent.validate(function() {
                    self.isFilled(true);
                });
            }
        };
    }
    DateField.prototype = Object.create(DateField.prototype);

    return DateField;
});