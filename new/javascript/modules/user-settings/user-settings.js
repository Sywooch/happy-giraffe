define(['jquery', 'knockout', 'text!user-settings/user-settings.html', 'models/User', 'models/Geography'], function userSettingsHandler($, ko, template, User, Geography) {
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
        this.getUserHandler = function getUserHandler(userData) {
            if (userData.success === true) {
                this.user.settleSettings(userData.data);
                this.loaded(true);
            }
        };
        this.beginEditField = function beginEditField(data, event) {
            data.editing(true);
            initSelect2();
        };
        this.parseCountries = function parseCountries(countriesResponse) {
            if (countriesResponse.success === true) {
                this.countries(countriesResponse.data);
                initGeographySelect2(this.user.address.value().country, this.user.address.value().city);
            }
        };
        this.beginLocationEditField = function beginEditField(data, event) {
            Geography.getCountries().done(this.parseCountries.bind(this));
            data.editing(true);
        };
        this.endEditField = function endEditField(data, event) {
            var attribute = {};
            attribute[data.name] = data.value();
            this.user.update(attribute).done(this.submitUserHandler.bind(this));
            data.editing(false);
        };
        this.endEditDateField = function endEditDateField(data, event) {
            this.user.updateDate().done(this.submitUserHandler.bind(this));
            data.editing(false);
        };
        this.changeEmailField = function changeEmailField(data, event) {
            this.user.changeEmail().done(this.submitUserHandler.bind(this));
            data.editing(false);
        };
        this.changePasswordField = function changeEmailField(data, event) {
            this.user.changePassword().done(this.submitUserHandler.bind(this));
            data.editing(false);
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
        function initSelect2() {
            // Измененный tag select
            $("select.select-cus__search-off").select2({
                width: '100%',
                minimumResultsForSearch: -1,
                dropdownCssClass: 'select2-drop__search-off',
                escapeMarkup: function(m) { return m; }
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
                    var data = {id: city.id, text: city.name};
                    callback(data);
                },
                ajax: {
                    url: "/api/geo/searchCities/",
                    dataType: 'json',
                    type: "POST",
                    delay: 250,
                    data: function (params) {
                        return JSON.stringify({
                            term: params,
                            countryId: country.id
                        });
                    },
                    results: function (data, page) {
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