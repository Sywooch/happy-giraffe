define(['jquery', 'knockout', 'text!user-settings/user-settings.html'], function userSettingsHandler($, ko, template) {
    function UserSettings(params) {

    };

    return {
        viewModel: UserSettings,
        template: template
    };
});