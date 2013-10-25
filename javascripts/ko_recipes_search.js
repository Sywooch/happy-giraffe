var RecipesSearchViewModel = function(data) {
    var self = this;

    self.loading = ko.observable(true);
    self.posts = ko.observable('');
    self.count = ko.observable(0);
    self.page = ko.observable(0);

    // query
    console.log(data.query);
    self.instantaneousQuery = ko.observable(data.query);
    self.throttledQuery = ko.computed(self.instantaneousQuery).extend({ throttle: 400 });

    self.clearQuery = function() {
        self.instantaneousQuery('');
    }

    // type
    self.recipeTypes = ko.utils.arrayMap(data.types, function(type) {
        return new ListItem(type);
    });
    self.selectedRecipeType = ko.observable(null);

    // cuisine
    self.cuisines = ko.utils.arrayMap(data.cuisines, function(cuisine) {
        return new ListItem(cuisine);
    });
    self.cuisines.unshift(new ListItem({ id : null, title : 'Любая' }));
    self.selectedCuisine = ko.observable(null);

    // duration
    self.durations = ko.utils.arrayMap(data.durations, function(duration) {
        return new ListItem(duration);
    });
    self.durations.unshift(new ListItem({ id : null, title : 'Не важно' }));
    self.selectedDuration = ko.observable(null);

    // diabetics
    self.forDiabetics1 = ko.observable(false);
    self.lowCal = ko.observable(false);
    self.forDiabetics2 = ko.observable(false);
    self.lowFat = ko.observable(false);

    self.search = function() {
        self.loading(true);
        var data = {};
        if (self.throttledQuery() != '')
            data.query = self.throttledQuery();
        if (self.selectedRecipeType() !== null)
            data.type = self.selectedRecipeType();
        if (self.selectedCuisine() !== null)
            data.cuisine = self.selectedCuisine();
        if (self.selectedDuration() !== null)
            data.duration = self.selectedDuration();
        if (self.forDiabetics1() || self.forDiabetics2())
            data.forDiabetics = true;
        if (self.lowCal())
            data.lowCal = true;
        if (self.lowFat())
            data.lowFat = true;
        if (self.page() != 0)
            data.page = self.page();
        $.post('/cook/recipe/searchResult/', data, function(response) {
            self.posts(response.posts);
            self.count(response.count);
            setTimeout(function() {
                $('.pager a').on('click', function() {

                    recipeSearchVM.page(parseInt($(this).text()) - 1);
                    return false;
                });
            }, 0);
            self.loading(false);
            $('html').animate({ scrollTop: 0 }, "slow");
        }, 'json');
    }

    self.reset = function() {
        self.page(1);
        self.instantaneousQuery('');
        self.selectedRecipeType(null);
        self.selectedCuisine(null);
        self.selectedDuration(null);
        self.forDiabetics1(false);
        self.lowCal(false);
        self.forDiabetics2(false);
        self.lowFat(false);
    }

    ko.computed(function() {
        self.page();
        self.throttledQuery();
        self.selectedRecipeType();
        self.selectedCuisine();
        self.selectedDuration();
        self.forDiabetics1();
        self.lowCal();
        self.forDiabetics2();
        self.lowFat();
        self.search();
    });
}

var ListItem = function(data) {
    var self = this;
    self.id = data.id;
    self.title = data.title;
}