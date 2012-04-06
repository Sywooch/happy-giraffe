var Attach = {
    entity : null,
    entity_id : null,
    base_url : null,
    params : new Array()
};

Attach.changeView = function(link) {
    $('#attach_content').load(link.href, function() {
        $(link).parent().addClass('active').siblings().removeClass('active');
    });
    return false;
};

Attach.updateEntity = function(entity, entity_id) {
    this.entity = entity;
    this.entity_id = entity_id;
    return true;
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
    if($('#change_ava').size() > 0 && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo')
        this.crop(id);
    else{
        if (this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo'){
            this.insertToComment(id);
        }else
            $.fancybox.close();
    }
};

Attach.selectBrowsePhoto = function(button) {
    var image = $('#upload_photo_container').children('img').clone(true);
    var fsn = $('#upload_photo_container').children('input').val();
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_fsn" />').val(fsn));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="Attach.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));

    if($('#change_ava').size() > 0 && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo')
        this.crop(fsn);
    else{
        if (this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo'){
            this.insertToComment(fsn);
        }else
            $.fancybox.close();
    }
    return false;
};

Attach.closeUpload = function(link) {
    $(link).siblings('.photo').find('.upload-container').empty();
    $(link).siblings('.photo').find('a').show();
    $(link).remove();
};

Attach.insertToComment = function(val) {
    var title = $('#photo_title').size() > 0 ? $('#photo_title').val() : null;
    $.post(base_url + '/albums/commentPhoto/', {val : val, title : title}, function(data) {
        if(CKEDITOR.instances[cke_instance] != undefined)
            CKEDITOR.instances[cke_instance].insertHtml('<img src="' + data.src + '" class="content-img" alt="' + data.title + '" title="' + data.title + '" />');
        $.fancybox.close();
    }, 'json');
};

Attach.saveCommentPhoto = function(fsn){
   $.ajax({
       url: Comment.saveCommentUrl,
       data: {entity:Comment.entity, entity_id:Comment.entity_id, file:fsn},
       type: 'POST',
       success: function() {
           $.fancybox.close();
           var pager = $('#comment_list .yiiPager .page:last');
           var url = false;
           if (pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span').text() != 'Редактировать')
               url = pager.children('a').attr('href');
           if (url !== false)
               $.fn.yiiListView.update('comment_list', {url:url, data:{lastPage:true}});
           else if ($('#add_comment .button_panel .btn-green-medium span span').text() == 'Редактировать')
               $.fn.yiiListView.update('comment_list');
           else
               $.fn.yiiListView.update('comment_list', {data:{lastPage:true}});
           var editor = Comment.getInstance();
           editor.setData('');
           editor.destroy();
           Comment.cancel();
       }
   });
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
        if($('#refresh_upload').size() > 0)
            document.location.reload();
    });
    $.fancybox.close();
    return false;
};