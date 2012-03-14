var Attach = {
    entity : null,
    entity_id : null,
    base_url : null
};

Attach.changeView = function(link) {
    $('#attach_content').load(link.href, function() {
        $(link).parent().addClass('active').siblings().removeClass('active');
    });
    return false;
};

Attach.changeAlbum = function(link) {
    $('#attach_content').load(link.href);
    return false;
};

