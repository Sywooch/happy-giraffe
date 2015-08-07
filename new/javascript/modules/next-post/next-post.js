define(['jquery', 'knockout', 'text!next-post/next-post.html', 'models/Model', 'waypoints'], function($, ko, template, Model) {
    function NextPost(params) {
        var self = this;
        self.getUrl = '/api/nextPost/get/';
        self.limit = 2;
        self.posts = ko.observableArray([]);
        self.loading = false;

        ko.bindingHandlers.nextPost = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var waypoint = new Waypoint({
                    element: element,
                    handler: function () {
                        if (self.loading === false ) {
                            self.loading = true;
                            Model.get(self.getUrl, { postId: params.postId }).done(function(response) {
                                if (response.success) {
                                    self.posts.push(response.data);
                                    this.context.refresh();
                                }
                                self.loading = false;
                            }.bind(this));
                        }
                    },
                    offset: 'bottom-in-view'
                });
            }
        };
    }

    return {
        viewModel: NextPost,
        template: template
    };
});