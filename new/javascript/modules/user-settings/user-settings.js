define(['jquery', 'knockout', 'text!user-settings/user-settings.html', 'models/User'], function userSettingsHandler($, ko, template, User) {
    function UserSettings(params) {
        this.userId = User.userId;
        this.loaded = ko.observable(false);
        this.user = Object.create(User);
        this.days = DateRange.days();
        this.months = DateRange.months();
        this.years = DateRange.years(1920, 2015);
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
        this.endEditField = function endEditField(data, event) {
            var attribute = {};
            attribute[data.name] = data.value();
            this.user.update(attribute).done(this.submitMemberHandler.bind(this));
            data.editing(false);
        };
        this.submitMemberHandler = function submitMemberHandler(familyMemberData) {
            if (familyMemberData.success === true) {
                this.user.updateModel(familyMemberData.data);
            }
            this.user.errorHandler(familyMemberData);
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

    };

    return {
        viewModel: UserSettings,
        template: template
    };
});