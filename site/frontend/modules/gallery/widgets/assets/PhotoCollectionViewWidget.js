var PhotoCollectionViewWidget = {
    originalState : null
}

PhotoCollectionViewWidget.open = function(collectionClass, collectionOptions, initialPhotoId, windowOptions) {
    initialPhotoId = (typeof initialPhotoId === "undefined") ? null : initialPhotoId;
    windowOptions = (typeof windowOptions === "undefined") ? null : windowOptions;

    this.originalState = History.getState();

    var data = { collectionClass : collectionClass, collectionOptions : collectionOptions };
    if (typeof windowOptions !== null)
        data.windowOptions = windowOptions;
    if (initialPhotoId !== null)
        data.initialPhotoId = initialPhotoId;
    $.get('/gallery/default/window/', data, function(response) {
        $('body').append(response);
    });
}

PhotoCollectionViewWidget.close = function() {
    $('#photo-window').remove();
    History.pushState(this.originalState.id, this.originalState.title, this.originalState.url);
}