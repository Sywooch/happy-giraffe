define(['jquery', 'knockout', 'models/Model', 'text!homepage-onair/homepage-onair.html'], function($, ko, Model, template) {
    function OnAir() {
        this.loadCommentsUrl = '/api/comments/onAir/';
        this.limit = 5;

        this.comments = [];

        this.prev = function prev() {
            console.log('1');
        };

        this.next = function next() {
            console.log('2');
        };

        this.loadComments = function loadComments() {
            //var lastCommentId = this.comments.length > 0 ?
            Model.get(this.loadCommentsUrl, { limit: this.limit})
        }
    }

    return {
        viewModel: OnAir,
        template: template
    };
});