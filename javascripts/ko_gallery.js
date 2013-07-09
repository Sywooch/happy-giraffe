function PhotoCollectionViewModel(data) {
    var self = this;
    self.count = data.count;
    self.photos = ko.utils.arrayMap(data.initialPhotos, function(photo) {
        return new Photo(photo, self);
    });

    self.getIndexById = function(photoId) {
        for (var photo in self.photos)
            if (self.photos[photo].id == photoId)
                return parseInt(photo);
    };

    self.currentPhotoIndex = ko.observable(self.getIndexById(data.initialPhotoId));

    console.log(typeof self.currentPhotoIndex());
    console.log(self.photos);

    self.currentPhoto = ko.computed(function() {
        return self.photos[self.currentPhotoIndex()];
    });

    self.nextHandler = function() {
        var newIndex = self.currentPhotoIndex() + 1;
        if (self.currentPhotoIndex() != self.photos.length - 1) {
            self.currentPhotoIndex(newIndex);
            self.preloadImages();
            if (self.currentPhotoIndex() >= self.photos.length - 3)
                self.preloadMetaNext();
        }
    }

    self.prevHandler = function() {
        var newIndex = self.currentPhotoIndex() - 1;
        if (self.currentPhotoIndex() != 0) {
            self.currentPhotoIndex(newIndex);
            self.preloadImages();
            if (self.currentPhotoIndex() <= 2)
                self.preloadMetaPrev();
        }
    }

    self.preloadImages = function() {
        var next = self.photos.slice(self.currentPhotoIndex() + 1, self.currentPhotoIndex() + 2);
        var prev = self.photos.slice(self.currentPhotoIndex() - 1, self.currentPhotoIndex());
        self.preload([next[0].src, prev[0].src]);
    }

    self.preload = function(arrayOfImages) {
        $(arrayOfImages).each(function(){
            $('<img/>')[0].src = this;
        });
    }

    self.preloadMetaNext = function() {
        $.get('/gallery/default/preloadNext/', { photoId : self.photos[self.photos.length - 1].id }, function(response) {
            for (var p in response.photos)
                self.photos.push(new Photo(response.photos[p], self));
        }, 'json');
    }

    self.preloadMetaPrev = function() {
        $.get('/gallery/default/preloadPrev/', { photoId : self.photos[0].id }, function(response) {
            for (var p in response.photos)
                self.photos.unshift(new Photo(response.photos[p], self));
        }, 'json');
    }

    self.preloadImages();
}

function Photo(data, parent) {
    var self = this;
    self.id = data.id;
    self.title = data.title;
    self.description = data.description;
    self.src = data.src;
    self.date = data.date;
    self.user = new User(data.user);
}

function User(data, parent) {
    var self = this;
    self.id = data.id;
    self.firstName = data.firstName;
    self.lastName = data.lastName;
    self.gender = data.gender;
    self.ava = data.ava;
    self.url = data.url;
    self.avaCssClass = self.gender == 1 ? 'male' : 'female';
}