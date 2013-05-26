ko.bindingHandlers.css2 = ko.bindingHandlers.css;

function FavouritesViewModel(data) {
    var self = this;

    self.favourites = ko.observableArray([]);
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
    self.loading = ko.observable(false);
    self.lastPage = ko.observable(false);

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

    self.activeMenuRow.subscribe(function(val) {
        self.init();
    });

    self.tagId.subscribe(function(val) {
        self.init();
    });

    self.keyword.subscribe(function(val) {
        self.init();
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

    self.load = function(callback, offset) {
        var data = {}

        if (self.activeMenuRow() !== null)
            data.entity = self.activeMenuRow();

        if (self.tagId() !== null)
            data.tagId = self.tagId();

        if (self.keyword() !== null)
            data.query = self.keyword();

        if (typeof offset !== "undefined")
            data.offset = offset;

        self.loading(true);
        $.get('/favourites/default/get/', data, function(response) {
            callback(response);
            self.loading(false);
            if (response.last)
                self.lastPage(true);
        }, 'json');
    }

    self.init = function() {
        self.load(function(response) {
            self.favourites(ko.utils.arrayMap(response.favourites, function(favourite) {
                return new Favourite(favourite, self);
            }));
        });
    }

    self.nextPage = function() {
        self.load(function(response) {
            var newItems = ko.utils.arrayMap(response.favourites, function(favourite) {
                return new Favourite(favourite, self);
            });

            self.favourites.push.apply(self.favourites, newItems);
        }, self.favourites().length);
    }

    self.init();

    $('.layout-container').scroll(function() {
        if (self.loading() === false && self.lastPage() === false && (($('.layout-container').scrollTop() + $('.layout-container').height()) > ($('.layout-container').prop('scrollHeight') - 200)))
            self.nextPage();
    });
}

function Favourite(data, parent) {
    var self = this;

    self.html = data.html;
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