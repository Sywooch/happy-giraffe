/*********************** user about ***********************/
function UserAboutWidget(about) {
    var self = this;
    self.about = ko.observable(about);
    self.new_about = ko.observable(about);
    self.editMode = ko.observable(false);

    self.edit = function () {
        console.log('sfahshf');
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
    self.isMyProfile = data.isMyProfile;
    self.adding = ko.observable(false);
    self.selectedCategory = ko.observable(null);
    self.pageSize = ko.observable(50);
    self.interests = ko.observableArray(ko.utils.arrayMap(data.interests, function (interest) {
        return new UserInterest(interest, self);
    }));
    self.categories = ko.observableArray(ko.utils.arrayMap(data.categories, function (category) {
        return new InterestCategory(category, self);
    }));
    self.allInterests = ko.observable([]);

    self.categoryInterests = ko.computed(function () {
        if (self.selectedCategory() != null) {
            return self.selectedCategory().interests;
        } else {
            self.allInterests([]);
            ko.utils.arrayForEach(self.categories(), function (category) {
                ko.utils.arrayForEach(category.interests(), function (interest) {
                    if (self.allInterests().length <= self.pageSize())
                        self.allInterests().push(interest);
                });
            });

            return self.allInterests();
        }
    });
    self.hasMore = ko.computed(function () {
        return self.categoryInterests().length > self.pageSize();
    });
    self.more = function () {
        self.pageSize(self.pageSize() + 50);
    };
    self.showAll = function () {
        self.selectedCategory(null);
    };

    //add your own interest
    self.newName = ko.observable('');
    self._addingNew = ko.observable(false);
    self.addNew = function () {
        if (self.interests().length < 25) {
            self._addingNew(false);
            $.post('/profile/addNewInterest/', {title: self.newName()}, function (response) {
                if (response.status) {
                    self.interests.push(new UserInterest({
                        id: response.id,
                        title: self.newName(),
                        active: true
                    }, self));
                    self.newName('');
                }
            }, 'json');
        }
    };
    self.addingNew = function () {
        if (self.interests().length < 25)
            self._addingNew(true);
    };
}

function InterestCategory(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = ko.observable(data.id);
    self.title = ko.observable(data.title);
    self.interests = ko.observableArray(ko.utils.arrayMap(data.interests, function (interest) {
        return new Interest(interest, self);
    }));

    self.select = function () {
        self.parent.selectedCategory(self);
        self.parent.pageSize(50);
    }
}

function Interest(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = ko.observable(data.id);
    self.title = ko.observable(data.title);
    self.active = ko.computed(function () {
        var active = false;
        ko.utils.arrayForEach(self.parent.parent.interests(), function (interest) {
            if (interest.id() == self.id())
                active = true;
        });

        return active;
    });

    self.add = function () {
        if (!self.active() && (self.parent.parent.interests().length < 25)) {
            $.post('/profile/toggleInterest/', {id: self.id()}, function (response) {
                if (response.status) {
                    var vm = self.parent.parent;
                    vm.interests.push(new UserInterest({
                        id: self.id(),
                        title: self.title(),
                        active: true
                    }, self.parent.parent));
                }
            }, 'json');
        }
    }
}

function UserInterest(data, parent) {
    var self = this;
    self.parent = parent;
    self.id = ko.observable(data.id);
    self.title = ko.observable(data.title);
    self.active = ko.observable(data.active);
    self.busy = ko.observable(false);

    self.users = ko.observableArray([]);
    self.count = ko.observable(null);

    self.isActive = ko.computed(function () {
        return self.active() && !self.parent.isMyProfile;
    });

    self.toggle = function () {
        if (!self.busy())
            $.post('/profile/toggleInterest/', {id: self.id()}, function (response) {
                if (response.status) {
                    self.active(!self.active());
                    if (self.active())
                        self.count(self.count() + 1);
                    else {
                        self.count(self.count() - 1);
                        if (self.parent.isMyProfile)
                            self.parent.interests.remove(self);
                    }
                }
                self.busy(false);
            }, 'json');
    };

    self.showDetails = ko.observable(false);
    self.hover = ko.observable(false);
    self.loadDetails = function () {
        $.post('/profile/interestData/', {id: self.id()}, function (response) {
            if (response.status) {
                ko.utils.arrayMap(response.users, function (user) {
                    self.users.push(new UserInterestUser(user));
                });
                self.count(response.count);
                self.showDetails(true);
            }
        }, 'json');
    };
    self.enableDetails = function () {
        self.hover(true);
        if (self.count() === null)
            self.loadDetails();
        else
            self.showDetails(true);
    };
    self.disableDetails = function () {
        self.hover(false);
        setTimeout(function () {
            if (!self.hover()) self.showDetails(false)
        }, 300);
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


/*********************** subscribe blog ***********************/
var ProfileBlogSubscription = function (data) {
    var self = this;
    self.active = ko.observable(data.active);
    self.id = ko.observable(data.id);
    self.toggle = function () {
        $.post('/profile/subscribeBlog/', {id: self.id()}, function (response) {
            if (response.status)
                self.active(!self.active());
        }, 'json');
    }
};

/*********************** subscribe community ***********************/
var UserClubsWidget = function (data, params) {
    var self = this;

    self.limit = params.limit;
    self.offset = params.offset;
    self.deleteClub = params.deleteClub;
    self.size = params.size;
    self.clubs = ko.observableArray(ko.utils.arrayMap(data, function (club) {
        return new UserClub(club, self.size, self);
    }));
    self.count = ko.computed(function () {
        return self.clubs().length;
    });
    self.TopClubs = ko.computed(function () {
        var shortList = [];
        ko.utils.arrayForEach(self.clubs(), function (club) {
            if (self.clubs().indexOf(club) >= self.offset && shortList.length < self.limit)
                shortList.push(club);
        });
        return shortList;
    });
};

var UserClub = function (data, size, parent) {
    var self = this;
    self.size = size;
    self.parent = parent;
    self.id = ko.observable(data.id);
    self.title = ko.observable(data.title);
    self.have = ko.observable(data.have);

    self.url = ko.computed(function () {
        return '/community/' + self.id() + '/';
    });
    self.src = ko.computed(function () {
        if (self.size == 'Big')
            return '/images/club/' + self.id() + '-w130.png';
        else
            return '/images/club/' + self.id() + '.png';
    });
    self.tooltipText = ko.computed(function () {
        return self.have() ? 'Покинуть клуб': 'Вступить в клуб';
    });
    self.toggle = function () {
        $.post('/ajaxSimple/communityToggle/', {community_id: self.id()}, function (response) {
            if (response.status){
                self.have(!self.have());
                if (self.parent.deleteClub && self.have()){
                    console.log('remove');
                    self.parent.clubs.remove(self);
                }
            }
        }, 'json');
    }
};