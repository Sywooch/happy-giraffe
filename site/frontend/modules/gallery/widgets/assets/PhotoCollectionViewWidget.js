var PhotoCollectionViewWidget = {
    originalState : null
}

PhotoCollectionViewWidget.open = function(collectionClass, collectionOptions, initialPhotoId, windowOptions) {
    this.originalState = History.getState();

    var data = { collectionClass : collectionClass, collectionOptions : collectionOptions, initialPhotoId : initialPhotoId };
    if (typeof windowOptions !== 'undefined')
        data.windowOptions = windowOptions;
    $.get('/gallery/default/window/', data, function(response) {
        $('body').append(response);
    });
}

PhotoCollectionViewWidget.close = function() {
    $('#photo-window').remove();
    History.pushState(this.originalState.id, this.originalState.title, this.originalState.url);
}