ko.bindingHandlers.length = {
    update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        var currentLength = valueAccessor().attribute().length;
        var maxLength = valueAccessor().maxLength;
        $(element).text(currentLength + '/' + maxLength);
    }
};

var BlogSettingsViewModel = function(data) {
    var self = this;
    self.titleValue = ko.observable(data.title);
    self.descriptionValue = ko.observable(data.description);
    self.title = ko.observable(data.title);
    self.description = ko.observable(data.description);
    self.photo = ko.observable(data.photo === null ? null : new Photo(data.photo));

    self.setTitle = function() {
        self.title(self.titleValue());
    }

    self.setDescription = function() {
        self.description(self.descriptionValue().replace(/\n/g, '<br />'));
    }

    self.titleHandler = function(data, event) {
        if (event.which == 13)
            self.setTitle()
        else
            return true;
    }

    self.save = function() {
        $.post(data.updateUrl, { blog_title : self.title(), blog_description : self.description(), blog_position : position }, function(response) {
            blogInfo.title(self.title());
            blogInfo.description(self.description());
            $.fancybox.close();
        }, 'json');
    }

    self.photoSrc = ko.computed(function() {
        return self.photo() === null ? '/images/jcrop-blog.jpg' : self.photo().src();
    });

    self.photoSrc.subscribe(function() {
        jcrop_api.destroy();
        $('.popup-blog-set_jcrop-img').Jcrop({
            setSelect: [ 0, 0, 100, 100 ],
            onChange: showPreview,
            onSelect: showPreview,
            aspectRatio: 720 / 128,
            boxWidth: 320
        });
    });

    $('#upload-target').on('load', function() {
        var response = $(this).contents().find('#response').text();
        if (response.length > 0)
            blogSettings.photo(new Photo($.parseJSON(response)));
    });
}

var Photo = function(data) {
    var self = this;
    self.id = ko.observable(data.id);
    self.src = ko.observable(data.src);
}

var BlogInfoViewModel = function(data) {
    var self = this;
    self.title = ko.observable(data.title);
    self.description = ko.observable(data.description);
}

/**
 * Настройки записи в блог
 */
function BlogRecordSettings(data) {
    var self = this;
    ko.mapping.fromJS(data, {}, self);
    self.displayOptions = ko.observable(false);
    self.displayPrivacy = ko.observable(false);

    self.attach = function(){
        $.post('/newblog/attachBlog/', {id: self.id()}, function (response) {
            if (response.status) {
                self.attached(!self.attached());
            }
        }, 'json');
        self.displayOptions(false);
    };
    self.show = function(){
        self.displayOptions(!self.displayOptions());
    };
    self.showPrivacy = function(){
        self.displayPrivacy(!self.displayPrivacy());
    };
    self.privacyClass = ko.computed(function () {
        if (self.privacy() == 0)
            return 'ico-users__all';
        else return 'ico-users__friend';
    });
    self.setPrivacy = function(privacy){
        $.post('/newblog/updatePrivacy/', {id: self.id(), privacy:privacy}, function (response) {
            if (response.status) {
                self.privacy(privacy);
                self.displayPrivacy(false);
            }
        }, 'json');

    };
}

ko.bindingHandlers.slideVisible = {
    init: function(element, valueAccessor) {
        var value = valueAccessor();
        $(element).toggle(ko.utils.unwrapObservable(value));
    },
    update: function(element, valueAccessor) {
        var value = valueAccessor();
        if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
            $(element).slideToggle(300);
    }
};

ko.bindingHandlers.toggleVisible = {
    init: function(element, valueAccessor) {
        var value = valueAccessor();
        $(element).toggle(ko.utils.unwrapObservable(value));
    },
    update: function(element, valueAccessor) {
        var value = valueAccessor();
        if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
            $(element).toggle(200);
    }
};