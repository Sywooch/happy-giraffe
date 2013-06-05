

function SearchViewModel(data) {
    var self = this;

    self.loading = ko.observable(false);
    self.loaded = ko.observable(false);
    self.totalCount = ko.observable(0);
    self.resultsToShow = ko.observable('');
    self.currentPage = ko.observable(1);
    self.menu = ko.observableArray(ko.utils.arrayMap(data.menu, function(menuRow) {
        return new MenuRow(menuRow, self);
    }));

    self.activeMenuRowIndex = ko.observable(null);
    self.activeMenuRow = ko.computed(function() {
        return self.menu()[self.activeMenuRowIndex()];
    });

    self.perPageValues = [10, 25, 50];
    self.perPage = ko.observable(self.perPageValues[0]);
    self.perPage.subscribe(function(value) {
        self.load();
    });

    self.scoringValues = ['по дате добавления', 'по рейтингу', 'по популярности'];
    self.scoring = ko.observable(0);
    self.scoring.subscribe(function(value) {
        self.load();
    });

    self.instantaneousQuery = ko.observable(data.query);
    self.throttledQuery = ko.computed(self.instantaneousQuery).extend({ throttle: 400 });
    self.throttledQuery.subscribe(function(value) {
        self.activeMenuRowIndex(null);
        self.load();
    });

    self.setPerPage = function(perPage) {
        self.perPage(perPage);
    };

    self.load = function(resetPage) {
        resetPage = (typeof resetPage === "undefined") ? true : resetPage;

        if (resetPage)
            self.currentPage(1);
        self.resultsToShow('');

        if (self.throttledQuery() != '') {
            var data = {
                perPage: self.perPage(),
                scoring: self.scoring(),
                query: self.throttledQuery()
            }

            if (self.currentPage() != 1)
                data.page = self.currentPage();

            if (self.activeMenuRowIndex() !== null)
                data.entity = self.activeMenuRow().entity;

            self.loading(true);
            $.get('/search/default/get/', data, function(response) {
                self.resultsToShow(response.results);
                if (self.currentPage() == 1 && self.activeMenuRowIndex() === null) {
                    self.updateFacets(response.facets);
                    self.totalCount(response.total);
                }
                self.loading(false);
                self.loaded(true);
            }, 'json');
        }
    };

    self.selectPage = function(page) {
        self.currentPage(page);
        self.load(false);
    }

    self.selectAll = function() {
        self.activeMenuRowIndex(null);
    }

    self.pages = ko.computed(function() {
        var count = self.activeMenuRowIndex() === null ? self.totalCount() : self.activeMenuRow().count();
        var pagesCount = Math.ceil(count / self.perPage());
        var pages = [];
        for (var i = 1; i <= pagesCount; i++)
            pages.push(i);
        return pages;
    });

    self.isMenuVisible = ko.computed(function() {
        var rowsCount = 0;
        ko.utils.arrayForEach(self.menu(), function(menuRow) {
            if (menuRow.count() > 0)
                rowsCount += 1;
        });

        return rowsCount > 1;
    });

    self.getMenuRowByEntity = function(entity) {
        return ko.utils.arrayFirst(self.menu(), function(menuRow) {
            return menuRow.entity == entity;
        });
    }

    self.updateFacets = function(facets) {
        ko.utils.arrayForEach(self.menu(), function(menuRow) {
            menuRow.count(0);
        });
        for (f in facets)
            self.getMenuRowByEntity(f).count(facets[f]);
    }

    self.load();
}

function MenuRow(data, parent) {
    var self = this;

    self.title = data.title;
    self.entity = data.entity;
    self.count = ko.observable(0);

    self.cssClass = ko.computed(function() {
        return 'menu-list_i__' + self.entity;
    });

    self.select = function(row) {
        parent.activeMenuRowIndex(parent.menu.indexOf(row));
        parent.load();
    }
}