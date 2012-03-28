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
    var image = $(button).parent().siblings('a').children('img').clone(true);
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_id" />').val(id));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="Attach.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    if($('#change_ava').size() > 0)
        this.crop(id);
    else
        $.fancybox.close();
};

Attach.selectBrowsePhoto = function(button) {
    var image = $('#upload_photo_container').children('img').clone(true);
    var fsn = $('#upload_photo_container').children('input').val();
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_fsn" />').val(fsn));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="Attach.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));

    if($('#change_ava').size() > 0)
        this.crop(fsn);
    else
        $.fancybox.close();
    return false;
};

Attach.closeUpload = function(link) {
    $(link).siblings('.photo').find('.upload-container').empty();
    $(link).siblings('.photo').find('a').show();
    $(link).remove();
};

Attach.crop = function(val) {
    $.post(base_url + '/albums/crop/', {val : val}, function(data) {

    });
};

Attach.changeAvatar = function(val) {
    $.post(base_url + '/albums/changeAvatar/', {val : val}, function(data) {
        $('#change_ava').empty().append($('<img />').attr('src', data));
    });
};