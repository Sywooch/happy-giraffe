Array.range = function (a, b, step) {
    var A = [];
    if (typeof a == 'number') {
        A[0] = a;
        step = step || 1;
        while (a + step <= b) {
            A[A.length] = a += step;
        }
    }
    else {
        var s = 'abcdefghijklmnopqrstuvwxyz';
        if (a === a.toUpperCase()) {
            b = b.toUpperCase();
            s = s.toUpperCase();
        }
        s = s.substring(s.indexOf(a), s.indexOf(b) + 1);
        A = s.split('');
    }
    return A;
};


function PersonalSettings(data) {
    var self = this;
    self.first_name = new PersonalSettingsAttribute(data.first_name, true);
    self.last_name = new PersonalSettingsAttribute(data.last_name, true);
    self.birthday = new DateWidget(data.birthday);
    self.email_subscription = ko.observable(data.email_subscription);
    self.location = new UserLocation(data.location);

    self.IsMale = ko.observable(data.gender.value == 1);
    self.setGender = function (val) {
        $.post('/user/settings/setValue/', {attribute: 'gender', value: val}, function (response) {

        }, 'json');

        return true;
    };

    self.toggleEmails = function () {
        var value = self.email_subscription() ? 0 : 1;
        $.post('/user/settings/mailSubscription/', {value: value}, function (response) {
            self.email_subscription(value);
        }, 'json');
    }
}

function PersonalSettingsAttribute(data, big) {
    var self = this;
    self.attribute = ko.observable(data.attribute);
    self.label = ko.observable(data.label);
    self.value = ko.observable(data.value);
    self.newValue = ko.observable(data.value);
    self.editOn = ko.observable(false);
    self.big = ko.observable(big);
    self.error = ko.observable('');

    self.edit = function () {
        self.editOn(true);
    };
    self.isBig = ko.computed(function () {
        return self.big() == true;
    });

    self.save = function () {
        $.post('/user/settings/setValue/', {
            attribute: self.attribute(),
            value: self.newValue()
        }, function (response) {
            if (response.status) {
                self.value(self.newValue());
                self.editOn(false);
                self.error('');
            } else {
                self.error(response.error);
            }
        }, 'json');
    }
}

function DateWidget(data) {
    var self = this;
    self.monthes = ko.observableArray([
        new DateWidgetMonth(1, 'января'),
        new DateWidgetMonth(2, 'февраля'),
        new DateWidgetMonth(3, 'марта'),
        new DateWidgetMonth(4, 'апреля'),
        new DateWidgetMonth(5, 'мая'),
        new DateWidgetMonth(6, 'июня'),
        new DateWidgetMonth(7, 'июля'),
        new DateWidgetMonth(8, 'августа'),
        new DateWidgetMonth(9, 'сентября'),
        new DateWidgetMonth(10, 'октября'),
        new DateWidgetMonth(11, 'ноября'),
        new DateWidgetMonth(12, 'декабря')
    ]);

    self.attribute = ko.observable(data.attribute);
    self.label = ko.observable(data.label);
    self.editOn = ko.observable(false);
    self.error = ko.observable('');

    self.day = ko.observable(data.day);

    self.getMonthById = function (id) {
        var result;
        ko.utils.arrayForEach(this.monthes(), function (month) {
            if (month.id == id)
                result = month;
        });
        return result;
    };
    self.month = ko.observable(self.getMonthById(data.month));
    self.year = ko.observable(data.year);

    self.selectedDay = ko.observable(data.day);
    self.selectedMonth = ko.observable(data.month);
    self.selectedYear = ko.observable(data.year);

    self.min_year = ko.observable(data.min_year);
    self.max_year = ko.observable(data.max_year);

    self.edit = function () {
        self.editOn(true);
    };
    self.text = ko.computed(function () {
        return self.day() + ' ' + self.month().name + ' ' + self.year() + ' г.';
    });
    self.days = ko.computed(function () {
        return Array.range(1, 31);
    });
    self.years = ko.computed(function () {
        return Array.range(self.min_year(), self.max_year());
    });
    self.newValue = ko.computed(function () {
        return self.selectedYear() + '-' + pad(self.selectedMonth(), 2) + '-' + pad(self.selectedDay(), 2);
    });

    self.save = function () {
        $.post('/user/settings/setValue/', {
            attribute: self.attribute(),
            value: self.newValue()
        }, function (response) {
            if (response.status) {
                self.day(self.selectedDay());
                self.month(self.getMonthById(self.selectedMonth()));
                self.year(self.selectedYear());
                self.editOn(false);
                self.error('');
            } else {
                self.error(response.error);
            }
        }, 'json');
    };
}


/**
 * Адрес
 * @param data
 * @constructor
 */
function UserLocation(data) {
    var self = this;
    self.editOn = ko.observable(false);

    self.country_id = ko.observable(data.country_id);
    self.country_code = ko.observable(data.country_code);
    self.selected_country_id = ko.observable(data.country_id);
    self.countries = ko.utils.arrayMap(data.countries, function (item) {
        return new Country(item.id, item.name, item.code);
    });
    self.country = ko.computed(function () {
        var result = false;
        ko.utils.arrayForEach(self.countries, function (country) {
            if (country.id == self.country_id())
                result = country;
        });
        return result;
    });


    self.region_id = ko.observable(data.region_id);
    self.selected_region_id = ko.observable(data.region_id);
    self.regions = ko.observableArray(ko.utils.arrayMap(data.regions, function (region) {
        return new Region(region.id, region.name, region.isCity);
    }));
    self.region = ko.computed(function () {
        var result = false;
        ko.utils.arrayForEach(self.regions(), function (region) {
            if (region.id == self.selected_region_id())
                result = region;
        });
        return result;
    });
    self.getRegionById = function (id) {
        var result;
        ko.utils.arrayForEach(self.regions(), function (region) {
            if (region.id == id)
                result = region;
        });
        return result;
    };
    self.regionVisible = ko.computed(function () {
        return self.regions().length > 0;
    });


    self.city_id = ko.observable(data.city_id);
    self.city_name = ko.observable(data.city_name);
    self.city = ko.computed(function () {
        return new City(self.city_id(), self.city_name(), '');
    });
    self.cities = ko.observableArray([new City(self.city_id(), self.city_name(), self.city_name())]);
    self.selected_city_id = ko.observable(data.city_id);
    self.getCityById = function (id) {
        var result;
        ko.utils.arrayForEach(self.cities(), function (city) {
            if (city.id() == id)
                result = city;
        });
        return result;
    };
    self.cityVisible = ko.computed(function () {
        return self.regionVisible() && self.region() && !self.region().isCity;
    });

    self.save = function () {
        $.post('/user/settings/saveLocation/', {
            country_id:self.selected_country_id(),
            region_id:self.selected_region_id(),
            city_id:self.selected_city_id()
        }, function (response) {
            if (response.status) {
                self.country_id(self.selected_country_id());
                self.region_id(self.selected_region_id());
                self.city_id(self.selected_city_id());
                var c = self.getCityById(self.city_id());
                if (c)
                    self.city_name(c.name());
                self.editOn(false);
            }
        }, 'json');
    };
    self.getFlag = function () {
        if (self.country())
            return self.country().code;
        return '';
    };
    self.text = ko.computed(function () {
        var region = self.getRegionById(self.region_id());
        if (region){
            if (region.isCity)
                return self.getRegionById(self.region_id()).name;
            else
                return self.getRegionById(self.region_id()).name + ' <br> ' + self.city().name();
        }
        return '';
    });
    self.CountryChanged = function () {
        $.post('/user/settings/regions/', {country_id: self.selected_country_id()}, function (response) {
            self.regions.removeAll();
            ko.utils.arrayForEach(response, function (region) {
                self.regions.push(new Region(region.id, region.name, region.isCity));
            });
            self.city_id(null);
            self.city_name('');
            self.selected_city_id(null);
        }, 'json');
    };
    self.RegionChanged = function () {
        self.city_id(null);
        self.city_name('');
        self.selected_city_id(null);
    };
}

var Country = function (id, name, code) {
    this.id = id;
    this.name = name;
    this.code = code;
};
var Region = function (id, name, isCity) {
    this.id = id;
    this.name = name;
    this.isCity = isCity;
};
var City = function (id, name, label) {
    this.id = ko.observable(id);
    this.name = ko.observable(name);
    this.label = ko.observable(label);
};

function getCities(searchTerm, sourceArray) {
    $.post('/user/settings/cities/', {
        region_id: Settings_vm.location.selected_region_id(),
        term: searchTerm
    }, function (response) {
        var result = [];
        ko.utils.arrayForEach(response, function (item) {
            result.push(new City(item.id, item.name, item.label));
        });
        sourceArray(result);
    }, 'json');
}


var DateWidgetMonth = function (id, name) {
    this.id = id;
    this.name = name;
};

function pad(str, max) {
    if (str == undefined)
        return '';
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}

function removeSocialService(el, id, service) {
    $.post('/profile/settings/removeService/', { id : id }, function(response) {
        if (response) {
            if ($(el).siblings().length > 1)
                $(el).parents('tr').remove();
            else
                $(el).parents('table').remove();
            $('.auth-service.' + service + ' a').show();
        }
    });
}