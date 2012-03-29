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
        $('#photoPick').replaceWith($(data));
        $('#crop_target').Jcrop({
            onChange: Attach.showPreview,
            onSelect: Attach.showPreview,
            aspectRatio: 1
        });
    });
};

Attach.showPreview = function(coords) {
    $('#photoPick .form-bottom').show();
    var rx = 72 / coords.w;
    var ry = 72 / coords.h;
    $('#coords_value').val(JSON.stringify(coords));
    $('#preview').css({
        width: Math.round(rx * $('#crop_target').width()) + 'px',
        height: Math.round(ry * $('#crop_target').height()) + 'px',
        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
        marginTop: '-' + Math.round(ry * coords.y) + 'px'
    });
}

Attach.changeAvatar = function(form) {
    var data = $(form).serialize();
    data += '&width=' + $('#crop_target').width() + '&height=' + $('#crop_target').height();
    $.post(base_url + '/albums/changeAvatar/', data, function(data) {
        $('#change_ava').addClass('filled').empty().append($('<img />').attr('src', data));
    });
    $.fancybox.close();
    if($('#refresh_upload').size() > 0)
        document.location.reload();
    return false;
};