function SearchViewModel(data) {
    var self = this;

    self.loading = ko.observable(false);
    self.loaded = ko.observable(false);
    self.totalCount = ko.observable(0);
    self.resultsToShow = ko.observable('');
    self.currentPage = ko.observable(1);
    self.menu = ko.observableArray(ko.utils.arrayMap(data.menu, function (menuRow) {
        return new SearchMenuRow(menuRow, self);
    }));

    self.activeMenuRowIndex = ko.observable(null);
    self.activeMenuRow = ko.computed(function () {
        return self.menu()[self.activeMenuRowIndex()];
    });

    self.perPageValues = [20, 50, 100];
    self.perPage = ko.observable(self.perPageValues[0]);
    self.perPage.subscribe(function (value) {
        self.load();
    });

    self.scoringValues = ['по дате добавления', 'по рейтингу', 'по популярности'];
    self.scoring = ko.observable(0);
    self.scoring.subscribe(function (value) {
        self.load();
    });

    self.query = ko.observable(data.query);

    self.setPerPage = function (perPage) {
        self.perPage(perPage);
    };

    self.search = function () {
        self.activeMenuRowIndex(null);
        self.load();
    };

    self.clearQuery = function () {
        self.query('');
        $('#search-query').focus();
    };
    self.newSearch = function () {
        self.query('');
        $('#search-query').focus();
        self.loaded(false);
    };

    self.load = function (resetPage) {
        resetPage = (typeof resetPage === "undefined") ? true : resetPage;

        if (resetPage)
            self.currentPage(1);
        self.resultsToShow('');

        if (self.query() != '') {
            var data = {
                perPage: self.perPage(),
                scoring: self.scoring(),
                query: self.query()
            };

            if (self.currentPage() != 1)
                data.page = self.currentPage();

            if (self.activeMenuRowIndex() !== null)
                data.entity = self.activeMenuRow().entity;

            self.loading(true);
            $.get('/search/default/get/', data, function (response) {
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

    self.selectPage = function (page) {
        self.currentPage(page);
        self.load(false);
    };

    self.selectAll = function () {
        self.activeMenuRowIndex(null);
        self.load();
    };

    self.pages = ko.computed(function () {
        var count = self.activeMenuRowIndex() === null ? self.totalCount() : self.activeMenuRow().count();
        var pagesCount = Math.ceil(count / self.perPage());
        var pages = [];
        var first_page = (self.currentPage() > 5) ? self.currentPage() - 5 : 1;
        var last_page = ((pagesCount - first_page) >= 10) ? (first_page + 9) : pagesCount;
        for (var i = first_page; i <= last_page; i++)
            pages.push(i);
        return pages;
    });

    self.isMenuVisible = ko.computed(function () {
        if (self.totalCount() == 0)
            return true;
        else {
            var rowsCount = 0;
            ko.utils.arrayForEach(self.menu(), function (menuRow) {
                if (menuRow.count() > 0)
                    rowsCount += 1;
            });

            return rowsCount > 1;
        }
    });

    self.getMenuRowByEntity = function (entity) {
        return ko.utils.arrayFirst(self.menu(), function (menuRow) {
            return menuRow.entity == entity;
        });
    };

    self.updateFacets = function (facets) {
        ko.utils.arrayForEach(self.menu(), function (menuRow) {
            menuRow.count(0);
        });
        if (facets !== null)
            for (f in facets)
                self.getMenuRowByEntity(f).count(facets[f]);
    };

    self.keyUp = function(data, event){
        if(event.keyCode == 13)
            self.load();
    };

    self.load();
}

function SearchMenuRow(data, parent) {
    var self = this;

    self.title = data.title;
    self.entity = data.entity;
    self.count = ko.observable(0);

    self.cssClass = ko.computed(function () {
        return 'menu-list_i__' + self.entity;
    });

    self.select = function () {
        parent.activeMenuRowIndex(parent.menu.indexOf(self));
        parent.load();
    }
}