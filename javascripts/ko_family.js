ko.bindingHandlers.css2 = ko.bindingHandlers.css;

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

var FamilyViewModel = function(data) {
    console.log(data);

    var self = this;

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
            console.log(response);
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

var FamilyMe = function(data, parent) {
    var self = this;

    self.gender = data.gender;
    self.relationshipStatus = ko.observable(data.relationshipStatus);

    self.cssClass = ko.computed(function() {
        return parent.getAdultCssClass(self.gender, self.relationshipStatus());
    });
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

var FamilyPartner = function(data, parent) {
    var self = this;

    self.isNewRecord = data.isNewRecord === undefined ? true : data.isNewRecord;
    self.relationshipStatus = data.relationshipStatus;

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

    self.isNewRecord = data.isNewRecord === undefined ? true : data.isNewRecord;
    self.gender = data.gender;
    self.ageGroup = data.ageGroup;
    self.type = data.type;

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
                return 'Ждём двойню';
        }

    }
}