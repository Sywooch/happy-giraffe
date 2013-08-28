function RepostWidget(data) {
    var self = this;

    self.modelName = data.modelName;
    self.modelId = data.modelId;
    self.entity = data.entity;
    self.count = ko.observable(data.count);
    self.active = ko.observable(data.active);
    self.ownContent = ko.observable(data.ownContent);
    self.adding = ko.observable(null);

    self.clickHandler = function() {
        if (self.ownContent())
            return;

        if (! self.active()) {
            $.get('/favourites/default/getEntityData/', { modelName : self.modelName, modelId : self.modelId}, function(response) {
                self.adding(new Entity(response, self));
            }, 'json');
        } else {
            self.remove();
        }
    }

    self.add = function(data, event) {
        if (self.ownContent())
            return;

        var el = $(event.target).parents('.favorites-control').find('.favorites-control_a');

        var data = {
            'Repost[model_name]' : self.modelName,
            'Repost[model_id]' : self.modelId,
            'Repost[note]' : self.adding().note()
        };

        $.post('/ajaxSimple/repostCreate/', data, function(response) {
            if (response.success) {
                self.adding(null);
                self.active(true);
            }
        }, 'json');
    };

    self.remove = function() {
        var data = {
            modelName : self.modelName,
            modelId : self.modelId
        };
        $.post('/ajaxSimple/repostDelete/', data, function(response) {
            if (response.success) {
                self.active(false);
            }
        }, 'json');
    };

    self.cancel = function() {
        self.adding(null);
    };

    self.active.subscribe(function(val) {
        val ? self.count(self.count() + 1) : self.count(self.count() - 1);
    });
}

