define(['jquery', 'knockout', 'text!user-settings/user-settings.html', 'models/User', 'models/Geography', 'extensions/SocialNetworks', 'eauth', 'knockout.mapping'], function userSettingsHandler($, ko, template, User, Geography, SocialNetworks) {
    function UserSettings(params) {
        this.userId = User.userId;
        this.loaded = ko.observable(false);
        this.user = Object.create(User);
        this.days = DateRange.days();
        this.months = DateRange.months();
        this.years = DateRange.years(1920, 2015);
        this.equalPassword = ko.observable('');
        this.mainPageUrl = '/';
        this.countries = ko.observableArray();
        this.redirectUser = function redirectUser() {
            document.location.href = this.mainPageUrl;
        };
        this.findById =  function findById(id, array) {
            var iterator;
            for (iterator = 0; iterator < array.length; iterator++) {
                if (id === array[iterator].id) {
                    return array[iterator];
                }
            }
            return false;
        };
        this.citySubs = function citySubs(val) {
            this.user.address.value().city().name($('.city-worshiper .select2-chosen').text());
        };
        this.countrySubs = function countrySubs(val) {
            this.user.address.value().country(ko.mapping.fromJS(this.findById(val, this.countries())));
            if (this.user.address.value().city().id() !== null) {
                this.user.address.value().city().id(null);
                this.user.address.value().city().name(null);
            }
            if (this.user.address.value().country().citiesFilled() === 1) {
                // Измененный tag select c инпутом поиска
                fireSelectCity(val);
            }
        };
        this.getUserHandler = function getUserHandler(userData) {
            if (userData.success === true) {
                this.user.settleSettings(userData.data);
                this.loaded(true);
                SocialNetworks.init(this.user.socialServices.value, 'a.ico-social__vkontakte', 'a.ico-social__odnoklassniki');
                this.user.countryId.subscribe(this.countrySubs, this);
                this.user.address.value().city().id.subscribe(this.citySubs, this);
            }
        };
        this.beginEditField = function beginEditField(data, event) {
            data.editing(true);
            initSelect2();
        };
        this.sortCountries = function sortCountries(a, b) {
            return a.pos - b.pos;
        };
        this.parseCountries = function parseCountries(countriesResponse) {
            if (countriesResponse.success === true) {
                this.countries(countriesResponse.data.sort(this.sortCountries));
                initGeographySelect2(this.user.address.value().country(), this.user.address.value().city());
            }
        };
        this.beginLocationEditField = function beginEditField(data, event) {
            Geography.getCountries().done(this.parseCountries.bind(this));
            data.editing(true);
        };
        this.endEditField = function endEditField(data, event) {
            var attribute = {};
            attribute[data.name] = data.value();
            this.user.update(attribute).done(function (userData) {
                this.submitWithHandling(userData, data);
            }.bind(this));
        };
        this.endEditDateField = function endEditDateField(data, event) {
            this.user.updateDate().done(function (userData) {
                this.submitWithHandling(userData, data);
            }.bind(this));
        };
        this.changeEmailField = function changeEmailField(data, event) {
            this.user.changeEmail().done(function (userData) {
                this.submitWithHandling(userData, data);
            }.bind(this));
        };
        this.changePasswordField = function changeEmailField(data, event) {
            this.user.changePassword().done(function (userData) {
                this.submitWithHandling(userData, data);
            }.bind(this));
        };
        this.changeGeographyField = function changeGeographyField(data, event) {
            this.user.changeLocation().done(function (userData) {
                this.submitWithHandling(userData, data);
            }.bind(this));
        };
        this.preSubmitUserHandler = function preSubmitUserHandler(userData) {
            this.submitWithHandling(userData, data);
        };
        this.submitWithHandling = function submitWithHandling(userData, fieldData) {
            fieldData.errors([]);
            this.user.errorHandler(userData);
            if (fieldData.errors().length > 0) {
                fieldData.editing(true);
            } else {
                fieldData.editing(false);
            }
        };
        this.submitUserHandler = function submitUserHandler(familyMemberData) {
            this.user.errorHandler(familyMemberData);
        };
        this.changeGender = function changeGender(data, event) {
            data.value(data.value().toString());
        };
        this.removeUser = function removeUser() {
            this.user.remove().done(this.redirectUser.bind(this));
        };
        this.changeSubscribtion = function changeGender(data, event) {
            this.user.updateSubscribtion();
        };
        User.getCurrentUser(40).done(this.getUserHandler.bind(this));
        var resultsShuffling = function resultsShuffling(data, page) {
                return {
                    results: $.map(data.data.cities, function (item) {
                        return {
                            text: item.name,
                            slug: item.name,
                            id: item.id
                        };
                    })
                };
            },
            dataTravesting = function dataTravesting(params) {
                return JSON.stringify({
                    term: params,
                    countryId: country.id
                });
            };
        function initSelect2() {
            // Измененный tag select
            $("select.select-cus__search-off").select2({
                width: '100%',
                minimumResultsForSearch: -1,
                dropdownCssClass: 'select2-drop__search-off',
                escapeMarkup: function(m) { return m; }
            });
        };
        function fireSelectCity(val) {
            $(".select-cus__search-on").select2({
                width: '100%',
                dropdownCssClass: 'select2-drop__search-on',
                searchInputPlaceholder: "Начните вводить",
                escapeMarkup: function(m) { return m; },
                ajax: {
                    url: "/api/geo/searchCities/",
                    dataType: 'json',
                    type: "POST",
                    delay: 250,
                    data: function dataTravesting(params) {
                        return JSON.stringify({
                            term: params,
                            countryId: val
                        });
                    },
                    results: resultsShuffling,
                    minimumInputLength: 1
                }
            });
        };
        function initGeographySelect2(country, city) {
            // Измененный tag select
            $(".select-cus__js-country").select2({
                width: '100%',
                minimumResultsForSearch: -1,
                dropdownCssClass: 'select2-drop__search-off select2-drop__separated-first-items',
            // escapeMarkup: function(m) { return m; }
            });
            // Измененный tag select c инпутом поиска
            $(".select-cus__search-on").select2({
                width: '100%',
                dropdownCssClass: 'select2-drop__search-on',
                searchInputPlaceholder: "Начните вводить",
                escapeMarkup: function(m) { return m; },
                initSelection : function (element, callback) {
                    var data = {id: city.id(), text: city.name()};
                    callback(data);
                },
                ajax: {
                    url: "/api/geo/searchCities/",
                    dataType: 'json',
                    type: "POST",
                    delay: 250,
                    data: function dataTravesting(params) {
                        return JSON.stringify({
                            term: params,
                            countryId: country.id
                        });
                    },
                    results: resultsShuffling,
                    minimumInputLength: 1
                }
            });
        };

    };

    return {
        viewModel: UserSettings,
        template: template
    };
});