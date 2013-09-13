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
    self.isMyProfile = data.isMyProfile;
    self.adding = ko.observable(false);
    self.selectedCategory = ko.observable(null);
    self.pageSize = ko.observable(50);
    self.interests = ko.observableArray(ko.utils.arrayMap(data.interests, function (interest) {
        return new UserInterest(interest, self);
    }));
    self.user_interests = ko.observableArray(ko.utils.arrayMap(data.user_interests, function (interest) {
        return new Interest(interest, self);
    }));
    self.categories = ko.observableArray(ko.utils.arrayMap(data.categories, function (category) {
        return new InterestCategory(category, self);
    }));

    /*********************** gather all interests in one array *************************/
    var allInterests = [];
    ko.utils.arrayForEach(self.categories(), function (category) {
        ko.utils.arrayForEach(category.interests(), function (interest) {
            allInterests.push(interest);
        });
    });
    ko.utils.arrayForEach(self.user_interests(), function (interest) {
        allInterests.push(interest);
    });
    self.allInterests = ko.observableArray(allInterests);
    self.allInterests.sort(function (left, right) {
        return left.count() == right.count() ? 0 : (left.count() < right.count() ? 1 : -1)
    });


    self.categoryInterests = ko.computed(function () {
        if (self.selectedCategory() != null) {
            return self.selectedCategory().interests;
        } else {
            var first = [];
            ko.utils.arrayForEach(self.allInterests(), function (interest) {
                if (first.length <= self.pageSize())
                    first.push(interest);
            });
            return first;
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
        return new Interest(interest, parent);
    }));
    self.interests.sort(function (left, right) {
        return left.count() == right.count() ? 0 : (left.count() < right.count() ? 1 : -1)
    });

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
    self.count = ko.observable(data.count);
    self.active = ko.computed(function () {
        var active = false;
        ko.utils.arrayForEach(self.parent.interests(), function (interest) {
            if (interest.id() == self.id())
                active = true;
        });

        return active;
    });

    self.add = function () {
        if (!self.active() && (self.parent.interests().length < 25)) {
            $.post('/profile/toggleInterest/', {id: self.id()}, function (response) {
                if (response.status) {
                    var vm = self.parent;
                    vm.interests.push(new UserInterest({
                        id: self.id(),
                        title: self.title(),
                        active: true
                    }, self.parent));
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
    self.detailsLoad = ko.observable(0);
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

    self.loadDetails = function () {
        if (self.detailsLoad() == 0) {
            self.detailsLoad(1);
            $.post('/profile/interestData/', {id: self.id()}, function (response) {
                if (response.status) {
                    ko.utils.arrayMap(response.users, function (user) {
                        self.users.push(new UserInterestUser(user));
                    });
                    self.count(response.count);
                }
            }, 'json');
        }
    };
    self.enableDetails = function () {
        if (self.count() === null)
            self.loadDetails();
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
    self.clubs.sort(function (left, right) {
        return left.id == right.id ? 0 : (left.id < right.id ? -1 : 1)
    });
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
    self.SingupClubs = ko.computed(function () {
        self.clubs().sort(function (club) {
            return club.have() ? -1 : 1;
        });

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
    self.url = ko.observable(data.url);

    self.src = ko.computed(function () {
        return '/images/club/' + self.id() + '-w130.png';
    });
    self.tooltipText = ko.computed(function () {
        return self.have() ? 'Покинуть клуб' : 'Вступить в клуб';
    });
    self.toggle = function () {
        if (userIsGuest)
            $('a[href=#login]').trigger('click');
        else
            $.post('/ajaxSimple/clubToggle/', {club_id: self.id()}, function (response) {
                if (response.status) {
                    self.have(!self.have());
                    if (self.parent.deleteClub && self.have()) {
                        self.parent.clubs.remove(self);
                    }
                }
            }, 'json');
    }
};

/************************** Загрузка аватары ***********************************/
var UserAva = function (data, container_selector) {
    var self = this;
    self.image_url = ko.observable(data.image_url);
    self.old_url = ko.observable(self.image_url());
    self.id = ko.observable(data.source_id);
    self.status = ko.observable(0);
    self._progress = ko.observable(0);

    self.jcrop_api = null;
    self.width = data.width;
    self.height = data.height;
    self.coordinates = data.coordinates;

    self.load = function () {
        if (self.image_url()) {
            self.status(2);
            $('#jcrop_target').Jcrop({
                trueSize: [self.width, self.height],
                onChange: self.showPreview,
                onSelect: self.showPreview,
                aspectRatio: 1,
                boxWidth: 438,
                minSize: [200, 200]
            }, function () {
                self.jcrop_api = this;
            });

            if (self.coordinates.length > 0) {
                setTimeout(function () {
                    self.jcrop_api.setSelect(self.coordinates);
                }, 200);
            }
        }
    };

    self.save = function () {
        $.post('/profile/setAvatar/', {source_id: self.id, coordinates: self.coordinates}, function (response) {
            if (response.status) {
                window.location.reload();
            }
        }, 'json');
    };
    self.cancel = function () {
        self.image_url(self.old_url());
        $.fancybox.close();
        window.setTimeout(function () {
            self.status(0);
            if (self.jcrop_api != null)
                self.jcrop_api.destroy();
        }, 500);
    };

    self.showPreview = function (coordinates) {
        self.coordinates = coordinates;
        var rx = 200 / coordinates.w;
        var ry = 200 / coordinates.h;

        $('#preview').css({
            width: Math.round(rx * self.width) + 'px',
            height: Math.round(ry * self.height) + 'px',
            marginLeft: '-' + Math.round(rx * coordinates.x) + 'px',
            marginTop: '-' + Math.round(ry * coordinates.y) + 'px'
        });
    };

    self.upload = function () {
        if (self.jcrop_api !== null)
            self.jcrop_api.destroy();
        self.status(1);
    };

    self.progress = ko.computed(function () {
        return self._progress() + '%';
    });

    self.complete = function (response) {
        self.width = response.width;
        self.height = response.height;
        self.id(response.id);
        self.image_url(response.image_url);
        $('#jcrop_target').removeAttr('style');
        self.status(2);

        setTimeout(function () {
            self.status(2);
            $('#jcrop_target').Jcrop({
                setSelect: [200, 200, 120, 120],
                trueSize: [self.width, self.height],
                onChange: self.showPreview,
                onSelect: self.showPreview,
                aspectRatio: 1,
                boxWidth: 438,
                minSize: [200, 200]
            }, function () {
                self.jcrop_api = this;
            });
        }, 200);
    };

    self.remove = function () {
        if (self.jcrop_api !== null)
            self.jcrop_api.destroy();
        self.image_url(null);
        self.status(0);
        self.id = ko.observable(null);
    };

    $.each($('.b-add-img'), function () {
        $(this)[0].ondragover = function () {
            $('.b-add-img').addClass('dragover')
        };
        $(this)[0].ondragleave = function () {
            $('.b-add-img').removeClass('dragover')
        };
    });

    $(container_selector + ' .js-upload-files-multiple').fileupload({
        dataType: 'json',
        url: '/ajaxSimple/uploadAvatar/',
        dropZone: $('#upload_ava_block'),
        add: function (e, data) {
            self.upload();
            data.submit();
        },
        done: function (e, data) {
            self.complete(data.result);
        }
    });

    $(container_selector + ' .js-upload-files-multiple').bind('fileuploadprogress', function (e, data) {
        self._progress(data.loaded * 100 / data.total);
    });

};