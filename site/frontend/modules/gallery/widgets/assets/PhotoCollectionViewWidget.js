var PhotoCollectionViewWidget = {
    originalState : null
}

PhotoCollectionViewWidget.open = function(collectionClass, collectionOptions, initialPhotoId) {
    this.originalState = History.getState();

    $.get('/gallery/default/window/', { collectionClass : collectionClass, collectionOptions : collectionOptions, initialPhotoId : initialPhotoId }, function(response) {
        $('body').append(response);
    });
}

PhotoCollectionViewWidget.close = function() {
    $('#photo-window').remove();
    History.pushState(this.originalState.id, this.originalState.title, this.originalState.url);
}