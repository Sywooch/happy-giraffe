// custom bindings

ko.bindingHandlers.draggable = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, context) {
        var value = valueAccessor();
        $(element).draggable({
            helper: 'clone',
            start: function(event, ui) {
                viewModel.beingDragged(value);
            }
        });
    }
};

ko.bindingHandlers.droppable = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, context) {
        var value = valueAccessor();
        $(element).droppable({
            hoverClass: 'dragover',
            drop: function(event, ui) {
                if (value(context.$data) === false)
                    $(element).addClass('dragover-error', 500, function() {
                        $(this).delay(2000).removeClass('dragover-error', 500);
                    });
            }
        });
    }
};

// common models

var FamilyCommonMe = function(data, parent) {
    var self = this;

    self.gender = data.gender;
    self.relationshipStatus = ko.observable(data.relationshipStatus);
}

var FamilyCommonPartner = function(data, parent) {
    var self = this;

    self.isNewRecord = data.isNewRecord === undefined ? true : data.isNewRecord;
    self.relationshipStatus = data.relationshipStatus;
}

var FamilyCommonBaby = function(data, parent) {
    var self = this;

    self.isNewRecord = data.isNewRecord === undefined ? true : data.isNewRecord;
    self.gender = data.gender;
    self.ageGroup = data.ageGroup;
    self.type = data.type;
}

var FamilyViewModel = function(data) {
    var self = this;

    self.callback = data.callback;
    self.beingDragged = ko.observable(null);
    self.family = ko.observableArray([]);

    self.add = function(content) {
        self.firstEmpty().content(content);
    };

    self.drop = function(data) {
        if (self.beingDragged() instanceof FamilyPartner) {
            if (self.hasPartner())
                return false;
            else
                self.me().relationshipStatus(self.beingDragged().relationshipStatus);
        }

        data.content(self.beingDragged());
        self.family.valueHasMutated();
    };

    self.firstEmpty = ko.computed(function() {
        return ko.utils.arrayFirst(self.family(), function(element) {
            return element.content() == null;
        });
    });

    self.getAdultCssClass = function(gender, relationshipStatus) {
        if (gender == 0) {
            switch (relationshipStatus) {
                case null:
                case 1:
                case 2:
                    return 'ico-family__wife';
                case 3:
                    return 'ico-family__girl-friend';
                case 4:
                    return 'ico-family__bride';
            }
        } else {
            switch (relationshipStatus) {
                case null:
                case 1:
                case 2:
                    return 'ico-family__husband';
                case 3:
                    return 'ico-family__boy-friend';
                case 4:
                    return 'ico-family__fiance';
            }
        }
    };

    self.addListElements = function(n) {
        for (var i = 0; i < n; i++)
            self.family.push(new FamilyListElement());
    };

    self.partner = ko.computed(function() {
        for (var i in self.family()) {
            if (self.family()[i].content() instanceof FamilyPartner)
                return self.family()[i].content();
        }
        return null;
    });

    self.hasPartner = ko.computed(function() {
        return self.partner() !== null;
    });

    self.familyMembersCount = ko.computed(function() {
        return self.family().reduce(function(previousValue, currentValue) {
            return previousValue + ! currentValue.isEmpty();
        }, 1);
    });

    self.emptyListElementsCount = ko.computed(function() {
        return self.family().reduce(function(previousValue, currentValue) {
            return previousValue + currentValue.isEmpty();
        }, 0);
    });

    self.emptyListElementsCount.subscribe(function(value) {
        if (value == 0)
            self.addListElements(3);
    });

    self.save = function() {
        var data = {};
        var babies = [];
        ko.utils.arrayForEach(self.family(), function(element) {
            if (element.content() instanceof FamilyBaby && element.content().isNewRecord)
                babies.push({ gender : element.content().gender, ageGroup : element.content().ageGroup, type : element.content().type });
        });
        data.babies = babies;
        data.createPartner = self.hasPartner() && self.partner().isNewRecord;
        data.relationshipStatus = self.me().relationshipStatus();
        console.log(data);
        $.post('/family/save/', data, function(response) {
            eval(self.callback);
        });
    }

    self.init = function() {
        switch (self.me().relationshipStatus()) {
            case 1:
            case 3:
            case 4:
                self.add(new FamilyPartner({ relationshipStatus : self.me().relationshipStatus(), isNewRecord : false }, self));
        }

        for (var i in data.babies) {
            self.add(new FamilyBaby($.extend({}, data.babies[i], { isNewRecord : false }), self));
        }
    }

    self.me = ko.observable(new FamilyMe(data.me, self));
    self.partnerModels = [
        new FamilyPartner({ relationshipStatus : 1 }, self),
        new FamilyPartner({ relationshipStatus : 3 }, self),
        new FamilyPartner({ relationshipStatus : 4 }, self)
    ];
    self.childrenModels = [
        new FamilyBaby({ gender : 1, ageGroup : null, type : 1 }, self),
        new FamilyBaby({ gender : 0, ageGroup : null, type : 1 }, self),
        new FamilyBaby({ gender : 2, ageGroup : null, type : 1 }, self),
        new FamilyBaby({ gender : 2, ageGroup : null, type : 3 }, self),
        new FamilyBaby({ gender : 0, ageGroup : 0, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 0, type : null }, self),
        new FamilyBaby({ gender : 0, ageGroup : 1, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 1, type : null }, self),
        new FamilyBaby({ gender : 0, ageGroup : 2, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 2, type : null }, self),
        new FamilyBaby({ gender : 0, ageGroup : 3, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 3, type : null }, self),
        new FamilyBaby({ gender : 0, ageGroup : 4, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 4, type : null }, self),
        new FamilyBaby({ gender : 0, ageGroup : 5, type : null }, self),
        new FamilyBaby({ gender : 1, ageGroup : 5, type : null }, self)
    ];

    self.addListElements(8);

    self.init();
}

var FamilyListElement = function() {
    var self = this;

    self.content = ko.observable(null);

    self.cssClass = ko.computed(function() {
        return self.content() === null ? false : self.content().cssClass();
    });

    self.title = ko.computed(function() {
        return self.content() === null ? false : self.content().title();
    })

    self.isEmpty = ko.computed(function() {
        return self.content() === null;
    });
}

var FamilyMe = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonMe(data));

    self.cssClass = ko.computed(function() {
        return parent.getAdultCssClass(self.gender, self.relationshipStatus());
    });
}

var FamilyPartner = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonPartner(data));

    self.cssClass = function() {
        return parent.getAdultCssClass((1 + parent.me().gender) % 2, self.relationshipStatus);
    }

    self.title = function() {
        if (parent.me().gender == 0) {
            switch (self.relationshipStatus) {
                case 1:
                    return 'Жена';
                case 3:
                    return 'Подруга';
                case 4:
                    return 'Невеста';
            }
        } else {
            switch (self.relationshipStatus) {
                case 1:
                    return 'Жена';
                case 3:
                    return 'Подруга';
                case 4:
                    return 'Невеста';
            }
        }
    };
}

var FamilyBaby = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonBaby(data));

    self.cssClass = function() {
        switch (self.type) {
            case null:
                var ageWord;
                switch (self.ageGroup) {
                    case 0:
                        ageWord = 'small';
                        break;
                    case 1:
                        ageWord = '3';
                        break;
                    case 2:
                        ageWord = '5';
                        break;
                    case 3:
                        ageWord = '8';
                        break;
                    case 4:
                        ageWord = '14';
                        break;
                    case 5:
                        ageWord = '19';
                }

                return 'ico-family__' + (self.gender == 1 ? 'boy' : 'girl') + '-' + ageWord;
            case 1:
                var genderWord;
                switch (self.gender) {
                    case 0:
                        return 'ico-family__girl-wait';
                    case 1:
                        return 'ico-family__boy-wait';
                    case 2:
                        return 'ico-family__baby';
                }
            case 3:
                return 'ico-family__baby-two';
        }
    }

    self.title = function() {
        switch (self.type) {
            case null:
                return self.gender == 1 ? 'Сын' : 'Дочь';
            case 1:
                switch (self.gender) {
                    case 0:
                        return 'Ждем девочку';
                    case 1:
                        return 'Ждем мальчика';
                    case 2:
                        return 'Ждем ребенка';
                }
            case 3:
                return 'Ждем двойню';
        }

    }
}

var FamilyMainViewModel = function(data) {
    var self = this;

    self.currentYear = data.currentYear;

    self.days = [];
    for (var i = 1; i <= 31; i++)
        self.days.push(i);

    self.years = [];
    for (var i = self.currentYear - 18; i <= self.currentYear; i++)
        self.years.push(i);

    self.monthes = [
        new FamilyMainMonth({ id : 1, name : 'января' }),
        new FamilyMainMonth({ id : 2, name : 'февраля' }),
        new FamilyMainMonth({ id : 3, name : 'марта' }),
        new FamilyMainMonth({ id : 4, name : 'апреля' }),
        new FamilyMainMonth({ id : 5, name : 'мая' }),
        new FamilyMainMonth({ id : 6, name : 'июня' }),
        new FamilyMainMonth({ id : 7, name : 'июля' }),
        new FamilyMainMonth({ id : 8, name : 'августа' }),
        new FamilyMainMonth({ id : 9, name : 'сентября' }),
        new FamilyMainMonth({ id : 10, name : 'октября' }),
        new FamilyMainMonth({ id : 11, name : 'ноября' }),
        new FamilyMainMonth({ id : 12, name : 'декабря' })
    ];

    self.getMonthLabel = function(id) {
        return ko.utils.arrayFirst(self.monthes, function(month) {
            return month.id == id;
        });
    }

    self.me = ko.observable(new FamilyMainMe(data.me, self));
    self.partner = ko.observable(data.partner === null ? null : new FamilyMainPartner(data.partner, self));
    self.babies = ko.utils.arrayMap(data.babies, function(baby) {
        return new FamilyMainBaby(baby, self);
    });

    self.normalBabies = ko.computed(function() {
        return ko.utils.arrayFilter(self.babies, function(baby) {
            return baby.type == null;
        });
    });

    self.waitingBaby = ko.computed(function() {
        return ko.utils.arrayFirst(self.babies, function(baby) {
            return baby.type == 1 || baby.type == 2;
        });
    });

    self.getBabyById = function(id) {
        return ko.utils.arrayFirst(self.babies, function(baby) {
            return baby.id == id;
        });
    };

    $('#partner-upload-target').on('load', function() {
        var response = $(this).contents().find('#response').text();
        if (response.length > 0) {
            var data = $.parseJSON(response);
            self.partner().photos.unshift(new FamilyMainPhoto(data.photo, self.partner()));
        }
    });

    $('#baby-upload-target').on('load', function() {
        var response = $(this).contents().find('#response').text();
        if (response.length > 0) {
            var data = $.parseJSON(response);
            var baby = self.getBabyById(data.id);
            console.log(baby);
            console.log(data.photo);
            baby.photos.unshift(new FamilyMainPhoto(data.photo, baby));
        }
    });
}

var FamilyMainMe = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonMe(data));
}

var FamilyMainMember = function(data, parent) {
    var self = this;

    self.id = data.id;

    // photos
    self.photos = ko.observableArray(ko.utils.arrayMap(data.photos, function(photo) {
        return new FamilyMainPhoto(photo, parent);
    }));

    // name
    self.name = ko.observable(data.name);
    self.nameValue = ko.observable(data.name);
    self.nameBeingEdited = ko.observable(false);

    self.editName = function() {
        self.nameBeingEdited(true);
    }

    self.saveNameCallback = function(response) {
        if (response.success) {
            self.name(self.nameValue());
            self.nameBeingEdited(false);
        }
    }

    // notice
    self.notice = ko.observable(data.notice);
    self.noticeValue = ko.observable(data.notice);
    self.noticeBeingEdited = ko.observable(false);

    self.editNotice = function() {
        self.noticeBeingEdited(true);
    }

    self.cancelEditNotice = function() {
        self.noticeBeingEdited(false);
    }

    self.saveNoticeCallback = function(response) {
        if (response.success) {
            self.notice(self.noticeValue());
            self.noticeBeingEdited(false);
        }
    }
}

var FamilyMainPartner = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonPartner(data, self));
    ko.utils.extend(self, new FamilyMainMember(data, self));
    self.TITLE_VALUES = ['Моя жена', 'Моя невеста', 'Моя подруга', 'Мой муж', 'Мой жених', 'Мой друг'];
    self.NOTICE_VALUES = ['О моей жене', 'О моей невесте', 'О моей подруге', 'О моем муже', 'О моем женихе', 'О моем друге'];
    self.PHOTOS_VALUES = ['Фото моей жены', 'Фото моей невесты', 'Фото моей подруги', 'Фото моего мужа', 'Фото моего жениха', 'Фото моего друга'];
    self.PHOTO_UPLOAD_URL = '/family/partner/uploadPhoto/';
    self.PHOTO_UPLOAD_TARGET = 'partner-upload-target';
    self.ENTITY_NAME = 'UserPartner';

    self.saveName = function() {
        $.post('/family/partner/updateAttribute/', { attribute : 'name', value : self.nameValue() }, function(response) {
            self.saveNameCallback(response);
        }, 'json');
    }

    self.saveNotice = function() {
        $.post('/family/partner/updateAttribute/', { attribute : 'notice', value : self.noticeValue() }, function(response) {
            self.saveNoticeCallback(response);
        }, 'json');
    }

    // labels
    self.titleLabel = function() {
        return self.getLabel(self.TITLE_VALUES);
    }

    self.noticeLabel = function() {
        return self.getLabel(self.NOTICE_VALUES);
    }

    self.photosLabel = function() {
        return self.getLabel(self.PHOTOS_VALUES);
    }

    self.getLabel = function(values) {
        var gender = (1 + parent.me().gender) % 2;
        var relationshipStatus = parent.me().relationshipStatus();
        return values[gender * 3 + (relationshipStatus == 1 ? relationshipStatus - 1 : relationshipStatus - 2)];
    }
}

var FamilyMainBaby = function(data, parent) {
    var self = this;
    ko.utils.extend(self, new FamilyCommonBaby(data, self));
    ko.utils.extend(self, new FamilyMainMember(data, self));
    self.PHOTO_UPLOAD_URL = '/family/baby/uploadPhoto/';
    self.PHOTO_UPLOAD_TARGET = 'baby-upload-target';
    self.ENTITY_NAME = 'Baby';

    // birthday
    self.birthday = ko.observable(data.birthday);
    self.birthdayBeingEdited = ko.observable(false);

    var birthdayArray = self.birthday().split('-');
    self.day = ko.observable(birthdayArray[2]);
    self.month = ko.observable(birthdayArray[1]);
    self.year = ko.observable(birthdayArray[0]);

    self.dayValue = ko.observable(birthdayArray[2]);
    self.monthValue = ko.observable(birthdayArray[1]);
    self.yearValue = ko.observable(birthdayArray[0]);

    self.birthdayText = ko.computed(function () {
        return self.day() + ' ' + parent.getMonthLabel(self.month()).name + ' ' + self.year() + ' г.';
    });

    self.birthdayValue = function() {
        return self.yearValue() + '-' + ("0" + self.monthValue()).slice(-2) + '-' + ("0" + self.dayValue()).slice(-2);
    }

    self.editBirthday = function() {
        self.birthdayBeingEdited(true);
    }

    self.saveBirthday = function() {
        $.post('/family/baby/updateAttribute/', { id : self.id, attribute : 'birthday', value : self.birthdayValue() }, function(response) {
            if (response.success) {
                self.day(self.dayValue());
                self.month(self.monthValue());
                self.year(self.yearValue());
                self.birthdayBeingEdited(false);
            }
        }, 'json');
    }

    self.saveName = function() {
        $.post('/family/baby/updateAttribute/', { id : self.id, attribute : 'name', value : self.nameValue() }, function(response) {
            self.saveNameCallback(response);
        }, 'json');
    }

    self.saveNotice = function() {
        $.post('/family/baby/updateAttribute/', { id : self.id, attribute : 'notice', value : self.noticeValue() }, function(response) {
            self.saveNoticeCallback(response);
        }, 'json');
    }

    // labels
    self.titleLabel = function() {
        switch (self.type) {
            case null:
                return self.gender == 1 ? 'Мой сын' : 'Моя дочь';
            case 1:
                switch (self.gender) {
                    case 0:
                        return 'Мы ждем девочку';
                    case 1:
                        return 'Мы ждем мальчика';
                    case 2:
                        return 'Мы ждем ребенка';
                }
            case 3:
                return 'Мы ждем двойню';
        }
    }

    self.noticeLabel = function() {
        return self.gender == 1 ? 'О моем сыне' : 'О моей дочери';
    }

    self.photosLabel = function() {
        return self.gender == 1 ? 'Фото моего сына' : 'Фото моей дочери';
    }

    self.birthdayLabel = function() {
        return self.gender == 1 ? 'День рождения моего сына' : 'День рождения моей дочери';
    }
}

var FamilyMainMonth = function(data, parent) {
    var self = this;
    self.id = data.id;
    self.name = data.name;
}

var FamilyMainPhoto = function(data, parent) {
    var self = this;
    self.id = data.id;
    self.bigThumbSrc = data.bigThumbSrc;
    self.smallThumbSrc = data.smallThumbSrc;

    self.open = function() {
        PhotoCollectionViewWidget.open('AttachPhotoCollection', { entityName : parent.ENTITY_NAME, entityId : parent.id }, self.id);
    }

    self.remove = function() {
        $.post('/albums/removeUploadPhoto/', { id : self.id }, function() {
            parent.photos.remove(self);
        });
    }
}