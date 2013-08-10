function PhotoCollectionViewModel(data) {
    var self = this;

    self.DESCRIPTION_MAX_WORDS = 32;

    self.collectionClass = data.collectionClass;
    self.collectionOptions = data.collectionOptions;
    self.count = data.count;
    self.photos = ko.utils.arrayMap(data.initialPhotos, function(photo) {
        return new CollectionPhoto(photo, self);
    });

    self.getIndexById = function(photoId) {
        for (var photo in self.photos)
            if (self.photos[photo].id == photoId)
                return parseInt(photo);
    };

    self.currentPhotoIndex = ko.observable(self.getIndexById(data.initialPhotoId));

    self.currentNaturalIndex = ko.observable(data.initialIndex + 1);

    self.currentPhoto = ko.computed(function() {
        return self.photos[self.currentPhotoIndex()];
    });

    self.isFullyLoaded = function() {
        return self.count == self.photos.length;
    };

    self.nextHandler = function() {
        if ((self.currentPhotoIndex() != self.photos.length - 1) || self.isFullyLoaded()) {
            self.currentPhotoIndex(self.currentPhotoIndex() != self.photos.length - 1 ? self.currentPhotoIndex() + 1 : 0);
            self.incNaturalIndex(true);
            self.preloadImages();
            if (! self.isFullyLoaded() && self.currentPhotoIndex() >= self.photos.length - 3)
                self.preloadMetaNext();
        }
    }

    self.prevHandler = function() {
        if ((self.currentPhotoIndex() != 0) || self.isFullyLoaded()) {
            self.currentPhotoIndex(self.currentPhotoIndex() != 0 ? self.currentPhotoIndex() - 1 : self.photos.length - 1);
            self.incNaturalIndex(false);
            self.preloadImages();
            if (! self.isFullyLoaded() && self.currentPhotoIndex() <= 2)
                self.preloadMetaPrev();
        }
    }

    self.preloadImages = function() {
        var next = self.photos[self.currentPhotoIndex() != self.photos.length - 1 ? self.currentPhotoIndex() + 1 : 0];
        var prev = self.photos[self.currentPhotoIndex() != 0 ? self.currentPhotoIndex() - 1 : self.photos.length - 1];
        self.preload([next.src, prev.src]);
    }

    self.preload = function(arrayOfImages) {
        $(arrayOfImages).each(function(){
            $('<img/>')[0].src = this;
        });
    }

    self.preloadMetaNext = function() {
        $.get('/gallery/default/preloadNext/', { collectionClass : self.collectionClass, collectionOptions : self.collectionOptions, photoId : self.photos[self.photos.length - 1].id, number : Math.min(self.count - self.photos.length, 10) }, function(response) {
            for (var p in response.photos)
                self.photos.push(new CollectionPhoto(response.photos[p], self));
        }, 'json');
    }

    self.preloadMetaPrev = function() {
        $.get('/gallery/default/preloadPrev/', { collectionClass : self.collectionClass, collectionOptions : self.collectionOptions, photoId : self.photos[0].id, number : Math.min(self.count - self.photos.length, 10) }, function(response) {
            for (var p in response.photos)
                self.photos.unshift(new CollectionPhoto(response.photos[p], self));
            self.currentPhotoIndex(self.currentPhotoIndex() + response.photos.length);
        }, 'json');
    }

    self.incNaturalIndex = function(n) {
        var rawIndex = self.currentNaturalIndex() + (n ? 1 : -1);
        var index;
        if (rawIndex == 0)
            index = data.count;
        else if(rawIndex > data.count)
            index = 1;
        else
            index = rawIndex;
        self.currentNaturalIndex(index);
    }

    self.preloadImages();
}

function CollectionPhoto(data, parent) {
    var self = this;
    self.id = data.id;
    self.title = data.title;
    self.description = data.description;
    self.src = data.src;
    self.date = data.date;
    self.user = new CollectionPhotoUser(data.user);
    self.showFullDescription = ko.observable(false);

    self.toggleShowFullDescription = function() {
        if (self.hasLongDescription())
            self.showFullDescription(! self.showFullDescription());
    }

    self.hasLongDescription = function() {
        return self.description.split(" ").length > parent.DESCRIPTION_MAX_WORDS;
    }

    self.shortenDescription = function() {
        var array = self.description.split(' ');
        var result = ' ';
        for (var i = 0; i < parent.DESCRIPTION_MAX_WORDS; i++)
            result += array[i] += ' ';
        return result;
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