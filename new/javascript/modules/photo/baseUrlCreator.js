define('photo/baseUrlCreator', ['photo-config'], function (photoConfig) {
    var thumb = '/v2/thumbs/';
    if (photoConfig.hostname !== undefined) {
        return 'http://www.virtual-giraffe.ru/proxy_public_file' + thumb;
    }
    return '';
});