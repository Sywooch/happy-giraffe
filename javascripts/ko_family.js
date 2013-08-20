ko.bindingHandlers.drag = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, context) {
        var value = valueAccessor();
        $(element).draggable({
            containment: 'window',
            helper: function(evt, ui) {
                var h = $(element).clone().css({
                    width: $(element).width(),
                    height: $(element).height()
                });
                h.data('ko.draggable.data', value(context, evt));
                return h;
            },
            appendTo: 'body'
        });
    }
};

ko.bindingHandlers.drop = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, context) {
        var value = valueAccessor();
        $(element).droppable({
            tolerance: 'pointer',
            hoverClass: 'dragover',
            activeClass: 'dragActive',
            drop: function(evt, ui) {
                value(ui.helper.data('ko.draggable.data'), context);
            }
        });
    }
};

var FamilyViewModel = function(data) {
    var self = this;

    self.family = ko.observableArray();

    self.add = function(content) {
        console.log('123');
        self.firstEmpty().content(content);
    };

    self.drag = function(data) {
        console.log(data);
    };

    self.drop = function(data, context) {
        console.log(data);
        console.log(context);
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

    console.log(parent);

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
        return self.content() === null ? '' : self.content().cssClass();
    });
}

var FamilyPartner = function(data) {
    var self = this;

    self.cssClass = ko.computed(function() {

    });
}

var FamilyBaby = function() {

}