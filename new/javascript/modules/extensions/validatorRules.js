define(['knockout', 'extensions/knockout.validation'], function (ko) {
    ko.validation.configure({
        registerExtenders: true,
        messagesOnModified: true,
        insertMessages: false
    });
    ko.validation.rules.mustFill = {
        validator: function mustFillHandler(val, bool) {
            if (val !== undefined && val !== null) {
                if (bool && val.trim() !== '') {
                    return true;
                }
                return false;
            }
        },
        message: 'Это обязательное поле'
    };
    ko.validation.rules.dateMustFill = {
        validator: function dateMustFillHandler(val, bool) {
            if (val !== undefined && val !== null) {
                if (bool) {
                    return true;
                }
                return false;
            }
        },
        message: 'Это обязательное поле'
    };
    ko.validation.registerExtenders();
});