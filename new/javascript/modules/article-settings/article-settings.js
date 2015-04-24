define(['jquery', 'knockout', 'text!article-settings/article-settings.html', 'models/Model', 'ko_library'], function ($, ko, template, Model) {
    function ArticleSettings(params) {
        this.removeBlogUrl = '/newblog/remove/';
        this.restoreBlogUrl = '/newblog/restore/';
        this.settingsClicker = 'a.article-settings_a__settings';
        this.settingsBlock = 'div.article-settings_hold';
        this.articleId = params.articleId;
        this.editUrl = params.editUrl;
        this.removed = ko.observable(false);
        this.removePost = function removePost() {
            $.post(this.removeBlogUrl, { id: this.articleId });
            this.removed(true);
        };
        this.restorePost = function restorePost() {
            $.post(this.restoreBlogUrl, { id: this.articleId });
            this.removed(false);
        };
        this.settingsShowHandler = function settingsShowHandler(data, evt) {
            $(evt.target).parent().siblings('div.article-settings_hold').toggle();
        };
    };

    return {
        viewModel: ArticleSettings,
        template: template
    };
});