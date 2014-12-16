define(['jquery', 'knockout', 'text!article-settings/article-settings.html', 'models/Model'], function ($, ko, template, Model) {
    function ArticleSettings(params) {
        this.removeBlogUrl = '/newblog/remove/';
        this.restoreBlogUrl = '/newblog/restore/';
        this.articleId = params.articleId;
        this.editUrl = params.editUrl;
        this.removePost = function removePost() {
            Model.get(this.removeBlogUrl, { id: this.articleId });
        };
    };

    return {
        viewModel: ArticleSettings,
        template: template
    };
});