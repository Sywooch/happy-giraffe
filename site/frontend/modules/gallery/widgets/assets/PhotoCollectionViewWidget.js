var PhotoCollectionViewWidget = {}

PhotoCollectionViewWidget.open = function(collectionClass, collectionOptions, initialPhotoId) {
    $.get('/gallery/default/window/', { collectionClass : collectionClass, collectionOptions : collectionOptions, initialPhotoId : initialPhotoId }, function(response) {
        $('body').append(response);
    });
}

PhotoCollectionViewWidget.close = function() {
    $('#photo-window').remove();
}