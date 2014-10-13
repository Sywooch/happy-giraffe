define('baseUrlCreator', ['photo-config'], function (photoConfig) {
    var thumb = '/v2/thumbs/';
    if (photoConfig.hostName !== undefined) {
        return photoConfig.hostName + thumb;
    }
    return '';
});