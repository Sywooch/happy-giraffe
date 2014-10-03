define(["jquery", "knockout"], function ($, ko) {
    ko.components.register('md-redactor', { require: 'md-redactor/md-redactor' });
    $('md-redactor').each(function(index) {
        ko.applyBindings({}, $(this)[0]);
    });
});