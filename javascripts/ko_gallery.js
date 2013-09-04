function PhotoCollectionViewModel(data) {
    var self = this;

    self.DESCRIPTION_MAX_WORDS = 32;

    self.collectionClass = data.collectionClass;
    self.collectionOptions = data.collectionOptions;
    self.userId = data.userId;
    self.count = data.count;
    self.url = data.url;
    self.photos = ko.utils.arrayMap(data.initialPhotos, function (photo) {
        return new CollectionPhoto(photo, self);
    });

    self.getIndexById = function (photoId) {
        for (var photo in self.photos)
            if (self.photos[photo].id == photoId)
                return parseInt(photo);
    };

    self.currentPhotoIndex = ko.observable(self.getIndexById(data.initialPhotoId));

    self.currentNaturalIndex = ko.observable(data.initialIndex + 1);

    self.currentPhoto = ko.computed(function () {
        return self.photos[self.currentPhotoIndex()];
    });

    self.currentPhoto.subscribe(function () {
        History.pushState(self.currentPhoto(), "Photo " + self.currentPhoto().id, self.currentPhoto().url());
        _gaq.push(['_trackPageview', self.currentPhoto().url()]);
        yaCounter11221648.hit(self.currentPhoto().url());
    });

    self.isFullyLoaded = function () {
        return self.count == self.photos.length;
    };

    self.nextHandler = function () {
        if ((self.currentPhotoIndex() != self.photos.length - 1) || self.isFullyLoaded()) {
            self.currentPhotoIndex(self.currentPhotoIndex() != self.photos.length - 1 ? self.currentPhotoIndex() + 1 : 0);
            self.incNaturalIndex(true);
            self.preloadImages();
            if (!self.isFullyLoaded() && self.currentPhotoIndex() >= self.photos.length - 3)
                self.preloadMetaNext();
            self.currentPhoto().loadComments();
        }
    }

    self.prevHandler = function () {
        if ((self.currentPhotoIndex() != 0) || self.isFullyLoaded()) {
            self.currentPhotoIndex(self.currentPhotoIndex() != 0 ? self.currentPhotoIndex() - 1 : self.photos.length - 1);
            self.incNaturalIndex(false);
            self.preloadImages();
            if (!self.isFullyLoaded() && self.currentPhotoIndex() <= 2)
                self.preloadMetaPrev();
            self.currentPhoto().loadComments();
        }
    }

    self.preloadImages = function () {
        var next = self.photos[self.currentPhotoIndex() != self.photos.length - 1 ? self.currentPhotoIndex() + 1 : 0];
        var prev = self.photos[self.currentPhotoIndex() != 0 ? self.currentPhotoIndex() - 1 : self.photos.length - 1];
        self.preload([next.src, prev.src]);
    }

    self.preload = function (arrayOfImages) {
        $(arrayOfImages).each(function () {
            $('<img/>')[0].src = this;
        });
    }

    self.preloadMetaNext = function () {
        $.get('/gallery/default/preloadNext/', { collectionClass: self.collectionClass, collectionOptions: self.collectionOptions, photoId: self.photos[self.photos.length - 1].id, number: Math.min(self.count - self.photos.length, 10) }, function (response) {
            for (var p in response.photos)
                self.photos.push(new CollectionPhoto(response.photos[p], self));
        }, 'json');
    }

    self.preloadMetaPrev = function () {
        $.get('/gallery/default/preloadPrev/', { collectionClass: self.collectionClass, collectionOptions: self.collectionOptions, photoId: self.photos[0].id, number: Math.min(self.count - self.photos.length, 10) }, function (response) {
            for (var p in response.photos)
                self.photos.unshift(new CollectionPhoto(response.photos[p], self));
            self.currentPhotoIndex(self.currentPhotoIndex() + response.photos.length);
        }, 'json');
    }

    self.incNaturalIndex = function (n) {
        var rawIndex = self.currentNaturalIndex() + (n ? 1 : -1);
        var index;
        if (rawIndex == 0)
            index = data.count;
        else if (rawIndex > data.count)
            index = 1;
        else
            index = rawIndex;
        self.currentNaturalIndex(index);
    }

    self.currentPhotoIndex.valueHasMutated();
    self.preloadImages();
}

function CollectionPhoto(data, parent) {
    var self = this;
    self.id = data.id;
    self.title = ko.observable(data.title);
    self.description = ko.observable(data.description);
    self.src = data.src;
    self.date = data.date;
    self.user = new CollectionPhotoUser(data.user);
    self.showFullDescription = ko.observable(false);
    self.likesCount = ko.observable(data.likesCount);
    self.isLiked = ko.observable(data.isLiked);
    self.favourites = ko.observable(new FavouriteWidget({
        modelName: 'AlbumPhoto',
        entity: 'AlbumPhoto',
        modelId:self.id,
        count: data.favourites.count,
        active: data.favourites.active
    }));

    self.toggleShowFullDescription = function () {
        if (self.hasLongDescription())
            self.showFullDescription(!self.showFullDescription());
    }

    self.hasLongDescription = function () {
        return self.description().split(" ").length > parent.DESCRIPTION_MAX_WORDS;
    }

    self.shortenDescription = function () {
        var array = self.description().split(' ');
        var result = ' ';
        for (var i = 0; i < parent.DESCRIPTION_MAX_WORDS; i++)
            result += array[i] += ' ';
        return result;
    }

    self.url = function () {
        return parent.url + 'photo' + self.id + '/';
    }

    self.loadComments = function () {
        $.post('/gallery/default/comments/', {id: self.id}, function (response) {
            $('#js-gallery-comment').html(response);
        });
    }

    self.like = function(data, event){
        $.post('/ajaxSimple/like/', {entity: 'AlbumPhoto', entity_id: self.id}, function (response) {
            if (response.status) {
                if (self.isLiked()){
                    self.isLiked(false);
                    self.likesCount(self.likesCount() - 1)
                }else{
                    self.isLiked(true);
                    self.likesCount(self.likesCount() + 1)
                }
            }
        }, 'json');
    }

    self.isEditable = parent.collectionClass == 'PhotoPostPhotoCollection';

    self.titleBeingEdited = ko.observable(data.title.length == 0);
    self.titleValue = ko.observable(data.title);
    self.saveTitle = function() {
        if (self.titleValue().length > 0)
            $.post('/gallery/default/updateTitle/', { id : self.id, title : self.titleValue() }, function(response) {
                if (response.success) {
                    self.title(self.titleValue());
                    self.titleBeingEdited(false);
                }
            }, 'json');
    }
    self.editTitle = function() {
        self.titleBeingEdited(true);
    }

    self.descriptionBeingEdited = ko.observable(data.description.length == 0);
    self.descriptionValue = ko.observable(data.description);
    self.saveDescription = function() {
        if (self.descriptionValue().length > 0)
            $.post('/gallery/default/updateDescription/', { id : self.id, contentId : parent.collectionOptions.contentId, description : self.descriptionValue() }, function(response) {
                if (response.success) {
                    self.description(self.descriptionValue());
                    self.descriptionBeingEdited(false);
                }
            }, 'json');
    }
    self.editDescription = function() {
        self.descriptionBeingEdited(true);
    }
}

function CollectionPhotoUser(data, parent) {
    var self = this;
    self.id = data.id;
    self.firstName = data.firstName;
    self.lastName = data.lastName;
    self.gender = data.gender;
    self.ava = data.ava;
    self.url = data.url;
    self.avaCssClass = self.gender == 1 ? 'male' : 'female';
}