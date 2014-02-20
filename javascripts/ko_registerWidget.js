function RegisterWidgetViewModel() {
    var self = this;

    self.STEP_REG1 = 0;
    self.STEP_REG2 = 1;
    self.STEP_EMAIL1 = 2;
    self.STEP_EMAIL2 = 3;

    self.currentStep = ko.observable(self.STEP_REG1);
}