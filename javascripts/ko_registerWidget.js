function RegisterWidgetViewModel(data, form) {
    var self = this;

    for (var i in data.constants)
        self[i] = data.constants[i];

    self.social = ko.observable(false);
    self.currentStep = ko.observable(self.STEP_REG1);

    self.id = ko.observable('');
    self.email = new RegisterUserAttribute('');
    self.first_name = new RegisterUserAttribute('');
    self.last_name = new RegisterUserAttribute('');
    self.country = ko.observable('');
    self.city = ko.observable('');
    self.birthday_year = new RegisterUserAttribute('');
    self.birthday_month = new RegisterUserAttribute('');
    self.birthday_day = new RegisterUserAttribute('');
    self.gender = new RegisterUserAttribute('');

    self.daysRange = DateRange.days();
    self.monthesRange = DateRange.months();
    self.yearsRange = DateRange.years(data.minYear, data.maxYear);
}

function RegisterUserAttribute(value)
{
    var self = this;
    self.val = ko.observable(value);
    self.show = ko.observable(true);
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