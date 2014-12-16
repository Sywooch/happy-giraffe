define(['jquery', 'knockout', 'text!article-settings/article-settings.html', 'models/Model'], function ($, ko, template, Model) {
    function ArticleSettings(params) {
        this.removeBlogUrl = '/newblog/remove/';
        this.restoreBlogUrl = '/newblog/restore/';
        this.settingsClicker = 'a.article-settings_a__settings';
        this.settingsBlock = 'div.article-settings_hold';
        this.articleId = params.articleId;
        this.editUrl = params.editUrl;
        this.removed = ko.observable(false);
        this.removePost = function removePost() {
            Model.get(this.removeBlogUrl, { id: this.articleId });
            this.removed(true);
        };
        this.restorePost = function restorePost() {
            Model.get(this.restoreBlogUrl, { id: this.articleId });
            this.removed(false);
        };
        this.settingsShowHandler = function settingsShowHandler(e) {
            e.preventDefault();
            console.log($(this), $(this).parent().siblings(this.settingsBlock));
            $(this).parent().siblings(this.settingsBlock).toggle();
        };
        $(this.settingsClicker).on('click', this.settingsShowHandler.bind(this));
    };

    return {
        viewModel: ArticleSettings,
        template: template
    };
});