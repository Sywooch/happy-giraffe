define(['jquery', 'knockout', 'text!article-settings/article-settings.html', 'models/Model'], function ($, ko, template, Model) {
    function ArticleSettings(params) {
        this.removeBlogUrl = '/newblog/remove/';
        this.restoreBlogUrl = '/newblog/restore/';
        this.settingsClicker = 'a.article-settings_a__settings';
        this.settingsBlock = 'div.article-settings_hold';
        this.articleId = params.articleId;
        this.editUrl = params.editUrl;
        this.removePost = function removePost() {
            Model.get(this.removeBlogUrl, { id: this.articleId });
        };
        this.settingsShowHandler = function settingsShowHandler(e) {
            e.preventDefault();
            $(this.settingsBlock).toggle();
        };
        $(this.settingsClicker).on('click', this.settingsShowHandler.bind(this));
    };

    return {
        viewModel: ArticleSettings,
        template: template
    };
});