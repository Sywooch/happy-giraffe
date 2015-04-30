define(['jquery', 'knockout', 'text!post-settings/post-settings.html', 'models/Model', 'ko_library'], function ($, ko, template, Model) {
    function PostSettings(params) {
        this.resultingSettings = params;
        this.removed = ko.observable(false);
        this.settingsClicker = 'a.article-settings_a__settings';
        this.settingsBlock = 'div.article-settings_hold';
        this.removePost = function removePost() {
            Model.get(this.resultingSettings.remove.api.url, { id: this.resultingSettings.remove.api.params.id });
            this.removed(true);
        };
        this.restorePost = function restorePost() {
            Model.get(this.resultingSettings.restore.api.url, { id: this.resultingSettings.restore.api.params.id });
            this.removed(false);
        };
        this.settingsShowHandler = function settingsShowHandler(data, evt) {
            $(evt.target).parent().siblings('div.article-settings_hold').toggle();
        };
    }

    return {
        viewModel: PostSettings,
        template: template
    };
});
