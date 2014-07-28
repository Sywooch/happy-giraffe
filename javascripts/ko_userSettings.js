function UserSettings(data)
{
    var self = this;

    $.each(data, function(key, item) {
        self[key] = ko.observable(item);
        self[key].subscribe(function(value) {
            self.update(key, value);
        });
    });

    self.toggle = function(key) {
        var observable = self[key];
        observable(! observable());
    }

    self.update = function(key, value) {
        $.post('/ajax/setUserAttribute/', { key : key, value : value });
    }
}