ko.bindingHandlers.tooltip = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
    },
    update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
        $(element).powerTip({
            placement: 'n',
            smartPlacement: true,
            popupId: 'tooltipsy-im',
            offset: 8
        });
    }
};

function FavouriteWidget(data) {
    var self = this;

    self.modelName = data.modelName;
    self.modelId = data.modelId;
    self.entity = data.entity;
    self.count = ko.observable(data.count);
    self.active = ko.observable(data.active);
    self.adding = ko.observable(null);
    self.favouritesMainPage = typeof favouritesModel !== "undefined";

    self.clickHandler = function() {
        if (! self.active()) {
            $.get('/favourites/default/getEntityData/', { modelName : self.modelName, modelId : self.modelId}, function(response) {
                self.adding(new Entity(response, self));
            }, 'json');
        } else {
            self.remove();
        }
    }

    self.add = function(data, event) {
        self.adding().addTag();
        var el = $(event.target).parents('.favorites-control').find('.favorites-control_a');

        var data = {
            'Favourite[model_name]' : self.modelName,
            'Favourite[model_id]' : self.modelId,
            'Favourite[note]' : self.adding().note(),
            'Favourite[tagsNames]' : self.adding().tags()
        }

        $.post('/favourites/favourites/create/', data, function(response) {
            if (response.success) {
                self.adding(null);
                self.active(true);
                el.flydiv({
                    flyTo: '.icon-favorites',
                    flyAddClass: 'flydiv active',
                    callback:function(){
                        $(".i-favorites").addClass('new').animate( { top:"-5px" },  { queue:true, duration:250 }  )
                            .animate( { top:"0" }, {
                                duration: 250,
                                complete: function() {
                                    $(this).removeClass('new');
                                }
                                /*$(".i-favorites").animate( {'height':'toggle'}, 'slow', 'easeOutBounce');*/
                            });
                    }
                });
                if (self.favouritesMainPage) {
                    favouritesModel.totalCount(favouritesModel.totalCount() + 1);
                    var menuRow = favouritesModel.getMenuRowByEntity(self.entity);
                    menuRow.count(menuRow.count() + 1);
                }
            }
        }, 'json');
    }

    self.remove = function() {
        var data = {
            modelName : self.modelName,
            modelId : self.modelId
        }
        $.post('/favourites/favourites/delete/', data, function(response) {
            if (response.success) {
                self.active(false);
                if (self.favouritesMainPage) {
                    favouritesModel.totalCount(favouritesModel.totalCount() - 1);
                    var menuRow = favouritesModel.getMenuRowByEntity(self.entity);
                    menuRow.count(menuRow.count() - 1);
                }
            }
        }, 'json');
    }

    self.cancel = function() {
        self.adding(null);
    }

    self.active.subscribe(function(val) {
        val ? self.count(self.count() + 1) : self.count(self.count() - 1);
    });
}

function Entity(data, parent) {
    var self = this;

    self.image = data.image;
    self.title = data.title;
    self.tags = ko.observableArray(data.tags);
    self.note = ko.observable(data.note);
    self.tagsInputIsVisible = ko.observable(self.tags().length == 0);
    self.tagsInputValue = ko.observable('');

    self.removeTag = function(tag) {
        self.tags.remove(tag);
    }

    self.showTagsForm = function() {
        self.tagsInputIsVisible(true);
    }

    self.tagHandler = function(data, event) {
        if (event.keyCode == 13 || event.keyCode == 44) {
            self.addTag();
        } else
            return true;
    }

    self.addTag = function() {
        if (self.tagsInputValue() != '' && self.tags().indexOf(self.tagsInputValue()) == -1) {
            self.tags.push(self.tagsInputValue());
            self.tagsInputValue('');
        }
    }
}