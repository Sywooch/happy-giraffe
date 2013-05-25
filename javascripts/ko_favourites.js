function FavouritesViewModel(data) {
    var self = this;

    self.totalCount = ko.observable(data.totalCount);
    self.menu = ko.observableArray(ko.utils.arrayMap(data.menu, function(menuRow) {
        return new MenuRow(menuRow, self);
    }));
    self.activeMenuRow = ko.observable(null);
    self.tagId = ko.observable(null);
    self.keyword = ko.observable(null);
    self.query = ko.observable('');
    self.activeTag = ko.observable(null);
    self.filter = ko.observable(null);

    self.query.subscribe(function(val) {
        if (val != '')
            $.get('/favourites/default/search/', { query : val }, function(response) {
                if (response.filter.type == 0) {
                    self.tagId(response.tagId);
                    self.filter(new Filter(response.filter));
                }
                else {
                    self.keyword(response.keyword);
                    self.filter(new Filter(response.filter));
                }
            }, 'json');
    });

    self.removeFilter = function() {
        self.tagId(null);
        self.keyword(null);
        self.filter(null);
        self.query('');
    }

    self.selectAll = function() {
        self.activeMenuRow(null);
    }

    self.clearQuery = function() {
        self.query('');
    }
}

function MenuRow(data, parent) {
    var self = this;

    self.entity = data.entity;
    self.title = data.title;
    self.count = ko.observable(data.count);

    self.cssClass = ko.computed(function() {
        return 'menu-list_i__' + self.entity;
    });

    self.select = function() {
        parent.activeMenuRow(self.entity);
    }
}

function Filter(data, parent) {
    var self = this;

    self.type = data.type;
    self.value = data.value;
    self.count = data.count;
}