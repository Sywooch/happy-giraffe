define('photo/baseUrlCreator', ['photo-config'], function (photoConfig) {
    var thumb = '/v2/thumbs/';
    if (photoConfig.hostname !== undefined) {
        return photoConfig.hostname + thumb;
    }
    return '';
});