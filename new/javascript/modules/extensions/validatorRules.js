define(['knockout', 'extensions/knockout.validation'], function (ko) {
    ko.validation.configure({
        registerExtenders: true,
        messagesOnModified: true
    });
    ko.validation.rules.mustFill = {
        validator: function (val, bool) {
            if (val !== undefined) {
                if (bool && val.trim() !== '') {
                    return true;
                }
                return false;
            }
        },
        message: 'Это обязательное поле'
    };
    ko.validation.registerExtenders();
});