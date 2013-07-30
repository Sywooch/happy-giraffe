/*********************** user about ***********************/
function UserAboutWidget(about) {
    var self = this;
    self.about = ko.observable(about);
    self.new_about = ko.observable(about);
    self.editMode = ko.observable(false);

    self.edit = function () {
        self.new_about(self.about());
        self.editMode(true);
    };

    self.canEdit = ko.computed(function () {
        return self.about().length != 0 && !self.editMode();
    });

    self.accept = function () {
        $.post('/profile/about/', { about: self.new_about() }, function (response) {
            if (response.status) {
                self.editMode(false);
                self.about(response.about);
                self.new_about(response.about);
            }
        }, 'json');
    };

    self.decline = function () {
        self.editMode(false);
    }
}

/*********************** interests ***********************/
function UserInterestsWidget(data) {
    var self = this;
    self.interests = ko.observableArray(ko.utils.arrayMap(data, function (interest) {
        return new UserInterest(interest, self);
    }));

}

function UserInterest(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = ko.observable(data.id);
    self.title = ko.observable(data.title);
    self.have = ko.observable(data.have);
    self.busy = ko.observable(false);

    self.users = ko.observableArray(ko.utils.arrayMap(data.users, function (user) {
        return new UserInterestUser(user);
    }));
    self.count = ko.observable(data.count);

    self.toggle = function () {
        if (!self.busy())
            $.post('/profile/toggleInterest/', {id: self.id()}, function (response) {
                if (response.status) {
                    self.have(!self.have());
                    if (self.have())
                        self.count(self.count() + 1);
                    else
                        self.count(self.count() - 1);
                }
                self.busy(false);
            }, 'json');
    };
}

function UserInterestUser(data) {
    var self = this;
    self.url = data.url;
    self.ava = data.ava;
    self.gender = data.gender;
    self.avatarClass = ko.computed(function () {
        return self.gender == 0 ? 'female' : 'male';
    }, this);
}