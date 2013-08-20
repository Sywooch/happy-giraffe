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
                value(context.$data);
            }
        });
    }
};

var FamilyViewModel = function(data) {
    var self = this;

    self.beingDragged = ko.observable(null);
    self.family = ko.observableArray();

    self.add = function(content) {
        self.firstEmpty().content(content);
    };

    self.drop = function(data) {
        console.log(data);
        console.log(self.beingDragged());
        data.content(self.beingDragged());
    };

    self.firstEmpty = ko.computed(function() {
        return ko.utils.arrayFirst(self.family(), function(element) {
            return element.content() == null;
        });
    });

    self.getAdultCssClass = function(gender, relationshipStatus) {
        if (gender == 0) {
            switch (self.relationshipStatus()) {
                case 1:
                    return 'ico-family__wife';
                case 3:
                    return 'ico-family__girl-friend';
                case 4:
                    return 'ico-family__bride';
            }
        } else {
            switch (relationshipStatus) {
                case 1:
                    return 'ico-family__husband';
                case 3:
                    return 'ico-family__boy-friend';
                case 4:
                    return 'ico-family__fiance';
            }
        }
    }

    self.me = ko.observable(new FamilyMe(data.me, self));

    for (var i = 0; i < 8; i++)
        self.family.push(new FamilyListElement());

    switch (self.me().relationshipStatus()) {
        case '1':
        case '3':
        case '4':
            self.add(new FamilyPartner(self.me().relationshipStatus()));
    }
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

var FamilyPartner = function(data) {
    var self = this;

    self.cssClass = ko.computed(function() {

    });
}

var FamilyBaby = function(gender, ageGroup) {
    var self = this;

    self.gender = gender;
    self.ageGroup = ageGroup;

    self.cssClass = function() {
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
    }

    self.title = function() {
        return self.gender == 1 ? 'Сын' : 'Дочь';
    }
}