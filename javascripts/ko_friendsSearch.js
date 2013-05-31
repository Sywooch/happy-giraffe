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

function FriendsSearchViewModel(data) {
    var self = this;

    self.query = ko.observable('');
    self.location = ko.observable('0');
    self.countries = ko.observableArray(ko.utils.arrayMap(data.countries, function(country) {
        return new Country(country);
    }));
    self.regions = ko.observableArray([]);
    self.selectedCountry = ko.observable('174');
    self.selectedRegion = ko.observable(null);
    self.gender = ko.observable('');
    self.minAge = ko.observable('18');
    self.maxAge = ko.observable('60');
    self.relationStatuses = [
        { id : 1, name: 'женат / замужем' },
        { id : 2, name: 'не женат / не замужем' },
        { id : 3, name: 'жених / невеста' },
        { id : 4, name: 'есть подруга / есть друг' }
    ];
    self.selectedRelationStatus = ko.observable(null);
    self.users = ko.observableArray([]);
    self.loading = ko.observable(false);
    self.currentPage = ko.observable(null);
    self.pageCount = ko.observable(null);
    self.childrenType = ko.observable('0');
    self.pregnancyWeekMin = ko.observable('1');
    self.pregnancyWeekMax = ko.observable('40');
    self.childAgeMin = ko.observable('0');
    self.childAgeMax = ko.observable('18');

    self.ages = [];
    self.pregnancyWeeks = [];
    self.childAges = []

    for (var i = 0; i <= 100; i++) {
        self.ages.push(i);
    }

    for (var i = 1; i <= 40; i++) {
        self.pregnancyWeeks.push(i);
    }

    for (var i = 0; i <= 18; i++) {
        self.childAges.push(i);
    }

    self.clearQuery = function() {
        self.query('');
    }

    self.clearForm = function() {
        self.query('');
        self.location('0');
        self.selectedCountry('174');
        self.selectedRegion(null);
        self.gender('');
        self.minAge('0');
        self.maxAge('100');
        self.selectedRelationStatus(null);
        self.childrenType('0');
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
            self.users(users);
        });
    }

    self.nextPage = function() {
        self.get(self.currentPage() + 1, function(users) {
            self.users.push.apply(self.users, users);
        });
    }

    self.updateTooltip = function(element) {
        $(element).find('.powertip').powerTip({
            placement: 'n',
            smartPlacement: true,
            popupId: 'tooltipsy-im',
            offset: 8
        });
    }

    self.updateRegions();
    self.search();

    $('.layout-container').scroll(function() {
        if (self.loading() === false && self.currentPage() != self.pageCount() && (($('.layout-container').scrollTop() + $('.layout-container').height()) > ($('.layout-container').prop('scrollHeight') - 200)))
            self.nextPage();
    });
}