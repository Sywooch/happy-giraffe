function RegisterWidgetViewModel(data) {
    var self = this;

    for (var i in data.constants)
        self[i] = data.constants[i];

    self.currentStep = ko.observable(self.STEP_REG1);
//    self.currentStep.subscribe(function(val) {
//        if (val == self.STEP_REG2) {
//            $('#registerForm').bind('ajax:complete', function(event) {
//                alert('123');
//                $('.popup-sign_row :has(.success)').hide();
//            });
//            $('#registerForm').submit();
//            $('#registerForm').off('ajax:complete');
//        }
//    });

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