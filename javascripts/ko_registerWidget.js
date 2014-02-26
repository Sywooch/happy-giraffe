function RegisterWidgetViewModel(data, form) {
    var self = this;

    for (var i in data.constants)
        self[i] = data.constants[i];

    self.social = ko.observable(false);
    self.currentStep = ko.observable(self.STEP_REG1);

    self.id = ko.observable();
    self.email = new RegisterUserAttribute('nikita@happy-giraffe.ru');
    self.first_name = new RegisterUserAttribute('1');
    self.last_name = new RegisterUserAttribute('2');
    self.country = ko.observable('');
    self.city = ko.observable('');
    self.birthday_year = new RegisterUserAttribute('');
    self.birthday_month = new RegisterUserAttribute('');
    self.birthday_day = new RegisterUserAttribute('');
    self.gender = new RegisterUserAttribute('');

    self.uid = ko.observable('');
    self.socialServiceName = ko.observable('');

    self.daysRange = DateRange.days();
    self.monthesRange = DateRange.months();
    self.yearsRange = DateRange.years(data.minYear, data.maxYear);

    self.resend = function() {
        self.currentStep(self.STEP_EMAIL2);
    }

    self.availableMailServices = ko.utils.arrayMap(data.mailServices, function(mailService) {
        return new MailService(mailService);
    });
    self.currentMailService = ko.computed(function() {
        var emailParts = self.email.val().split('@');
        if (emailParts.length != 2)
            return null;

        var domain = emailParts[1];
        for (var i in self.availableMailServices) {
            if (self.availableMailServices[i].domains.indexOf(domain) != -1)
                return self.availableMailServices[i];
        }
        return null;
    });
}

function MailService(data)
{
    var self = this;
    self.name = data.name;
    self.url = data.url;
    self.domains = data.domains;
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