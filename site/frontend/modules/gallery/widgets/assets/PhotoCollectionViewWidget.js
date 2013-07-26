var PhotoCollectionViewWidget = {}

PhotoCollectionViewWidget.open = function(id) {
    $.get('/gallery/default/window/', { initialPhotoId : id }, function(response) {
        $('body').append(response);
    });
}

PhotoCollectionViewWidget.close = function() {
    $('#photo-window').remove();
}