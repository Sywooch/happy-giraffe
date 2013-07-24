function FriendsSearchViewModel(data) {
    var self = this;

    // значения по умолчанию
    var DEFAULT_COUNTRY = 174;
    var DEFAULT_MIN_AGE = 18;
    var DEFAULT_MAX_AGE = 60;
    var DEFAULT_CHILD_MIN_AGE = 0;
    var DEFAULT_CHILD_MAX_AGE = 18;
    var DEFAULT_PREGNANCY_WEEK_MIN = 1;
    var DEFAULT_PREGNANCY_WEEK_MAX = 40;

    // имя и/или фамилия
    self.instantaneousQuery = ko.observable('');
    self.query = ko.computed(this.instantaneousQuery).extend({ throttle: 400 });

    // местоположение
    self.location = ko.observable('0');
    self.selectedCountry = ko.observable(DEFAULT_COUNTRY);
    self.selectedRegion = ko.observable(null);

    self.countries = ko.observableArray(ko.utils.arrayMap(data.countries, function(country) {
        return new Country(country);
    }));
    self.regions = ko.observableArray([]);

    self.gender = ko.observable(''); // пол

    // возраст
    self.minAge = ko.observable(DEFAULT_MIN_AGE);
    self.maxAge = ko.observable(DEFAULT_MAX_AGE);
    self.ages = [];
    for (var i = 0; i <= 100; i++) {
        self.ages.push(i);
    }

    // семейное положение
    self.relationStatuses = [
        { id : 1, name: 'женат / замужем' },
        { id : 2, name: 'не женат / не замужем' },
        { id : 3, name: 'жених / невеста' },
        { id : 4, name: 'есть подруга / есть друг' }
    ];
    self.selectedRelationStatus = ko.observable(null);

    // дети
    self.childrenType = ko.observable('0');
    self.childAgeMin = ko.observable(DEFAULT_CHILD_MIN_AGE);
    self.childAgeMax = ko.observable(DEFAULT_CHILD_MAX_AGE);
    self.pregnancyWeekMin = ko.observable(DEFAULT_PREGNANCY_WEEK_MIN);
    self.pregnancyWeekMax = ko.observable(DEFAULT_PREGNANCY_WEEK_MAX);
    self.pregnancyWeeks = [];
    for (var i = 1; i <= 40; i++) {
        self.pregnancyWeeks.push(i);
    }
    self.childAges = []
    for (var i = 0; i <= 18; i++) {
        self.childAges.push(i);
    }

    self.users = ko.observableArray([]);
    self.loading = ko.observable(false);
    self.currentPage = ko.observable(null);
    self.pageCount = ko.observable(null);

    self.clearQuery = function() {
        self.instantaneousQuery('');
    }

    self.clearForm = function() {
        self.instantaneousQuery('');
        self.location('0');
        self.selectedCountry(DEFAULT_COUNTRY);
        self.selectedRegion(null);
        self.gender('');
        self.minAge(DEFAULT_MIN_AGE);
        self.maxAge(DEFAULT_MAX_AGE);
        self.selectedRelationStatus(null);
        self.childrenType('0');
        self.childAgeMin(DEFAULT_CHILD_MIN_AGE);
        self.childAgeMax(DEFAULT_CHILD_MAX_AGE);
        self.pregnancyWeekMin(DEFAULT_PREGNANCY_WEEK_MIN);
        self.pregnancyWeekMax(DEFAULT_PREGNANCY_WEEK_MAX);
    }

    self.updateRegions = function() {
        $.get('/friends/default/regions/', { countryId : self.selectedCountry() }, function(response) {
            self.regions(ko.utils.arrayMap(response, function(region) {
                return new Region(region);
            }));
        }, 'json');
    }

    self.get = function(page, callback) {
        var data = {
            ageMin : self.minAge(),
            ageMax : self.maxAge()
        };

        if (page > 1) {
            data.User_page = page;
        }

        if (self.query() != '')
            data.query = self.query();

        if (self.gender() != '')
            data.gender = self.gender();

        if (self.location() == '1') {
            if (self.selectedCountry() !== null)
                data.countryId = self.selectedCountry();

            if (self.selectedRegion() !== null)
                data.regionId = self.selectedRegion();
        }

        if (self.selectedRelationStatus() !== null)
            data.relationshipStatus = self.selectedRelationStatus();

        if (self.childrenType() != '0') {
            data.childrenType = self.childrenType();
            switch(self.childrenType()) {
                case '1':
                    data.pregnancyWeekMin = self.pregnancyWeekMin();
                    data.pregnancyWeekMax = self.pregnancyWeekMax();
                    break;
                case '2':
                    data.childAgeMin = self.childAgeMin();
                    data.childAgeMax = self.childAgeMax();
                    break;
            }
        }

        self.loading(true);
        $.get('/friends/search/get/', data, function(response) {
            self.loading(false);
            self.currentPage(response.currentPage);
            self.pageCount(response.pageCount);
            callback(response.users);
        }, 'json');
    }

    self.search = function() {
        self.users([]);
        self.get(1, function(users) {
            self.users(ko.utils.arrayMap(users, function(user) {
                return new OutgoingFriendRequest(user, self);
            }));
            $(".layout-container").animate({ scrollTop: 0 }, "slow");
        });
    }

    self.nextPage = function() {
        self.get(self.currentPage() + 1, function(users) {
            self.users.push.apply(self.users, ko.utils.arrayMap(users, function(user) {
                return new OutgoingFriendRequest(user, self);
            }));
        });
    }

    self.updateRegions();
    self.search();

    $('.layout-container').scroll(function() {
        if (self.loading() === false && self.users().length > 0 && self.currentPage() != self.pageCount() && (($('.layout-container').scrollTop() + $('.layout-container').height()) > ($('.layout-container').prop('scrollHeight') - 200)))
            self.nextPage();
    });

    ko.computed(function() {
        self.search();
    });
}

function Country(data, parent) {
    var self = this;

    self.id = data.id;
    self.name = data.name;
}

function Region(data, parent) {
    var self = this;

    self.id = data.id;
    self.name = data.name;
}

ko.bindingHandlers.chosen =
{
    init: function(element)
    {
        $(element).addClass('chzn');
        $(element).chosen();
    },
    update: function(element)
    {
        $(element).trigger('liszt:updated');
    }
};

ko.bindingHandlers.tooltip = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
    },
    update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
        $(element).powerTip({
            placement: 'n',
            smartPlacement: true,
            popupId: 'tooltipsy-im',
            offset: 8
        });
    }
};
