var BlogSettingsViewModel = function(data) {
    var self = this;
    self.title = ko.observable(data.title);
    self.description = ko.observable(data.description);
}