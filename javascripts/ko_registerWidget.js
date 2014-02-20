function RegisterWidgetViewModel() {
    var self = this;

    self.STEP_REG1 = 'signupStep1';
    self.STEP_REG2 = 'signupStep2';
    self.STEP_EMAIL1 = 'signupEmail1';
    self.STEP_EMAIL2 = 'signupEmail2';

    self.currentStep = ko.observable(self.STEP_REG1);

    self.email = ko.observable('');
    self.first_name = ko.observable('');
    self.last_name = ko.observable('');
}