(function(window) {
    function f(ko) {
        ko.bindingHandlers.css2 = ko.bindingHandlers.css;

        function FavouritesViewModel(data) {
            var self = this;

            self.favourites = ko.observableArray([]);
            self.totalCount = ko.observable(data.totalCount);
            self.menu = ko.observableArray(ko.utils.arrayMap(data.menu, function(menuRow) {
                return new MenuRow(menuRow, self);
            }));
            self.activeMenuRowIndex = ko.observable(data.entity === null ? null : self.menu.indexOf(ko.utils.arrayFirst(this.menu(), function(menuRow) {
                return menuRow.entity == data.entity;
            })));
            self.tagId = ko.observable(data.tagId);
            self.keyword = ko.observable(null);
            self.instantaneousQuery = ko.observable('');
            self.throttledQuery = ko.computed(this.instantaneousQuery).extend({ throttle: 400 });
            self.filter = ko.observable(null);
            self.loading = ko.observable(false);
            self.lastPage = ko.observable(false);
            self.history = new AjaxHistory('favourites');

            self.isMenuVisible = ko.computed(function() {
                var rowsCount = 0;
                ko.utils.arrayForEach(self.menu(), function(menuRow) {
                    if (menuRow.count() > 0)
                        rowsCount += 1;
                });

                return rowsCount > 1;
            });

            self.activeMenuRow = ko.computed(function() {
                return self.menu()[self.activeMenuRowIndex()];
            });

            self.throttledQuery.subscribe(function(val) {
                if (val != '') {
                    $.get('/favourites/default/search/', { query : val }, function(response) {
                        if (response.filter.type == 0) {
                            self.tagId(response.tagId);
                            self.filter(new Filter(response.filter));
                        }
                        else {
                            self.keyword(response.keyword);
                            self.filter(new Filter(response.filter));
                        }
                        self.history.changeBrowserUrl(self.history.buildUrl('', { query : val }));
                    }, 'json');
                } else {
                    self.history.changeBrowserUrl(document.location.origin + '/favourites/');
                }
            });

            self.activeMenuRow.subscribe(function(val) {
                self.init();
            });

            self.filter.subscribe(function(val) {
                self.init();
            });

            self.removeFilter = function() {
                self.tagId(null);
                self.keyword(null);
                self.filter(null);
                self.instantaneousQuery('');
            }

            self.selectAll = function() {
                self.activeMenuRowIndex(null);
            }

            self.clearQuery = function() {
                self.instantaneousQuery('');
            }

            self.load = function(callback, offset) {
                var data = {}

                if (self.activeMenuRowIndex() !== null)
                    data.entity = self.activeMenuRow().entity;

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
                self.favourites([]);
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

            if (data.query !== null)
                self.instantaneousQuery(data.query);

            self.init();

            $(window).scroll(function() {
                if (self.loading() === false && self.lastPage() === false && (($(window).scrollTop() + $(window).height()) > (document.documentElement.scrollHeight - 500)))
                    self.nextPage();
            });
        }

        function Favourite(data, parent) {
            var self = this;

            self.id = data.id;
            self.modelName = data.modelName;
            self.modelId = data.modelId;
            self.html = data.html;
            self.note = ko.observable(data.note);
            self.tags = ko.observable(data.tags);
            self.editing = ko.observable(null);

            self.showEditForm = function() {
                $.get('/favourites/default/getEntityData/', { modelName : self.modelName, modelId : self.modelId}, function(response) {
                    self.editing(new Entity(response, self));
                }, 'json');
            }

            self.cancel = function() {
                self.editing(null);
            }

            self.edit = function() {
                var data = {
                    favouriteId : self.id,
                    'Favourite[note]' : self.editing().note(),
                    'Favourite[tagsNames]' : self.editing().tags()
                }
                $.post('/favourites/favourites/update/', data, function(response) {
                    if (response.success) {
                        self.note(self.editing().note());
                        self.tags(self.editing().tags());
                        self.editing(null);
                    }
                }, 'json');
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

            self.select = function(row) {
                parent.activeMenuRowIndex(parent.menu.indexOf(row));
            }
        }

        function Filter(data, parent) {
            var self = this;

            self.type = data.type;
            self.value = data.value;
            self.count = data.count;
        }
        
        return FavouritesViewModel;
    }
    if (typeof define === 'function' && define['amd']) {
        define('ko_favourites', ['knockout', 'history', 'ko_library'], f);
    } else {
        window.FavouritesViewModel = f(window.ko);
    }
})(window);