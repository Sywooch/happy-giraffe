(function(window) {
    function f(ko) {
        var PhotoWidgetViewModel = function(data) {
            var self = this;

            self.widgetId = data.widgetId;
            self.contentId = data.contentId;

            self.title = ko.observable(data.title);
            self.hidden = ko.observable(data.hidden);
            self.checkedPhoto = ko.observable(data.checkedPhoto);
            self.photos = ko.utils.arrayMap(data.photos, function(photo) {
                return new PhotoWidgetPhoto(photo, self);
            });

            self.toggleHidden = function() {
                self.hidden(! self.hidden());
            }

            self.save = function() {
                var data = { title : self.title(), hidden : self.hidden(), item_id : self.checkedPhoto(), contentId : self.contentId };
                if (self.widgetId !== null)
                    data.widgetId = self.widgetId;
                $.post('/community/default/photoWidgetSave/', data, function(response) {
                    if (response.success)
                        $.fancybox.close();
                }, 'json');
            }
        }

        var PhotoWidgetPhoto = function(data, parent) {
            var self = this;

            self.id = data.id;
            self.url = data.url;

            self.isChecked = ko.computed(function() {
                return parent.checkedPhoto() == self.id;
            });

            self.setPhoto = function() {
                parent.checkedPhoto(self.id);
            }
        }
        
        return PhotoWidgetViewModel;
    }
    if (typeof define === 'function' && define['amd']) {
        define('ko_photoWidget', ['knockout', 'ko_photoWidget', 'ko_library', 'ko_blog', 'ko_upload'], f);
    } else {
        window.PhotoWidgetViewModel = f(window.ko);
    }
})(window);