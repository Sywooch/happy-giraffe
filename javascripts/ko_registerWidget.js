function RegisterWidgetViewModel(data, form) {
    var self = this;

    for (var i in data.constants)
        self[i] = data.constants[i];

    self.social = ko.observable(false);
    self.currentStep = ko.observable(self.STEP_REG1);
    self.currentStep.subscribe(function(val) {
        if (val == self.STEP_REG2) {
            setTimeout(function() {
                var settings = form.data("settings");
                $.each(settings.attributes, function () {
                    this.status = 2;
                });
                form.data("settings", settings);

                $.fn.yiiactiveform.validate(form, function (data) {
                    $.each(settings.attributes, function () {
                        $.fn.yiiactiveform.updateInput(this, data, form);
                    });
                    $('.popup-sign_attr:has(.success):visible').hide();
                    form.triggerHandler('reset');
                });
            }, 1);
        }
    });

    self.id = ko.observable();
    self.email = ko.observable();
    self.first_name = ko.observable();
    self.last_name = ko.observable();
    self.country = ko.observable();
    self.city = ko.observable();
    self.birthday_year = ko.observable();
    self.birthday_month = ko.observable();
    self.birthday_day = ko.observable();
    self.gender = ko.observable();

    self.daysRange = DateRange.days();
    self.monthesRange = DateRange.months();
    self.yearsRange = DateRange.years(data.minYear, data.maxYear);
}

function LoginWidgetViewModel() {
    var self = this;

    self.email = ko.observable();
    self.password = ko.observable();
    self.rememberMe = ko.observable();
}

function PasswordRecoveryWidgetViewModel() {
    var self = this;

    self.email = ko.observable();
    self.isSent = ko.observable(false);

    self.login = function() {
        loginVm.email(self.email());
        return true;
    }
}