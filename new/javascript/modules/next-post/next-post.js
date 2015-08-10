define(['jquery', 'knockout', 'text!next-post/next-post.html', 'models/Model', 'extensions/adhistory', 'waypoints'], function($, ko, template, Model, AdHistory) {
    function NextPost(params) {
        var self = this;
        self.post = params.post;
        self.getUrl = '/api/nextPost/get/';
        self.limit = 2;
        self.posts = ko.observableArray([]);
        self.loading = false;
        self.finish = false;

        ko.bindingHandlers.nextPost = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var waypoint = new Waypoint({
                    element: element,
                    handler: function () {
                        if (self.loading === false && self.finish === false && self.posts().length < self.limit) {
                            self.loading = true;

                            var exclude = [self.post.id];
                            for (var i in self.posts()) {
                                exclude.push(self.posts()[i].id);
                            }
                            Model.get(self.getUrl, { postId: self.post.id, exclude: exclude }).done(function(response) {
                                if (response.success) {
                                    self.posts.push(response.data);
                                    this.context.refresh();
                                } else {
                                    self.finish = true;
                                }
                                self.loading = false;
                            }.bind(this));
                        }
                    },
                    offset: 'bottom-in-view'
                });
            }
        };

        ko.bindingHandlers.waypoint = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var value = valueAccessor();
                var url = value.url;
                var title = value.title;



                var waypoint = new Waypoint({
                    element: element,
                    handler: function() {
                        document.title = title;
                        AdHistory.pushState(null, title, url);
                    }
                });
            }
        };
    }

    return {
        viewModel: NextPost,
        template: template
    };
});

// ИСКЛЮЧИТЬ ИЗ ВЫБОРКИ ПОСТОВ ТЕ, КОТОРЫЕ УЖЕ ОТОБРАЖАЮТСЯ НА СТРАНИЦЕ!!!
// ПОФИКСИТЬ ЗАГРУЗКУ ФОТОПОСТОВ