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

Attach.selectPhoto = function(button, id) {
    var image = $(button).parent().siblings('a').children('img');
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image.clone(true));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_id" />').val(id));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="Attach.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    $.fancybox.close();
};

Attach.selectBrowsePhoto = function(button) {
    var image = $('#upload_photo_container').children('img');
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image.clone(true));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_fsn" />').val($('#upload_photo_container').children('input').val()));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="Attach.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    $.fancybox.close();
    return false;
}

Attach.closeUpload = function(link) {
    $(link).siblings('.photo').find('.upload-container').empty();
    $(link).siblings('.photo').find('a').show();
    $(link).remove();
}
