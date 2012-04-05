var Album = {
    editMode : false,
    album_id : false
};
Album.editDescription = function (link, tmp) {
    var note = $(link).parents('.note:eq(0)');
    $('.fast-actions', note).hide();
    if (!tmp) {
        var html = $('<form><textarea placeholder="Введите комментарий к альбому не более 140 символов"></textarea><button class="btn btn-green-small"><span><span>Ок</span></span></button></form>');
        $('textarea', html).val($('p', note).text());
        $('p', note).remove();
        html.appendTo(note);
    } else {
        $('form', note).show();
    }
    $('form', note).bind('submit', function () {
        Album.saveDescription(this);
        return false;
    });
    return false;
};

Album.saveDescription = function (button, tmp) {
    var note = $(button).parents('.note:eq(0)');
    var text = $('textarea', note).val();
    $('<p></p>').text(text).appendTo(note);
    $('.fast-actions', note).show();
    if (tmp) {
        $('form', note).hide();
    } else {
        $('form', note).remove();
        $.post($('.fast-actions a', note).attr('href'), {text:text});
        if(text == '')
            $('.fast-actions a', note).removeClass('edit').addClass('add');
        else
            $('.fast-actions a', note).removeClass('add').addClass('edit');
    }
};

Album.removeDescription = function (link) {
    $.post(link.href, {text:''});
    $(link).parents('.note:eq(0)').remove();
    return false;
};

/* Изменение названия фотографии */
Album.editPhoto = function (link) {
    $(link).parents('tr:eq(0)').addClass('editing');
    var text = $(link).siblings('span').text();
    $(link).parent().hide().siblings('div').show().find('input[type=text]').val(text);
    return false;
};

/* Сохранение названия фотографии */
Album.savePhoto = function (button) {
    $(button).parents('tr:eq(0)').removeClass('editing');
    var text = $(button).siblings('input[type=text]').val();
    $(button).parent().hide().siblings('div').show().find('span').text(text);
    if (!this.editMode) {
        var url = $(button).parent().hide().siblings('div').find('a.edit').attr('href');
        $.post(
            url,
            {title:text}
        );
    }
    return false;
};

Album.removePhoto = function (button, data) {
    $('#album_photo_' + data['Removed[entity_id]']).remove();
    if (!this.editMode) {
        $.fn.yiiListView.update('comment_list_view');
    }
};

Album.removeAlbum = function () {
    document.location.href = base_url + '/albums';
};

Album.changeAlbum = function(select) {
    if($(select).val() == '') {
        this.album_id = null;
        if($('#new_album_title').val() == '') {
            clearFlash();
            $('#upload_button_wrapper').addClass('disabled');
        }
        return false;
    }
    this.album_id = $(select).val();

    upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/' + $(select).val() + '/');
    $('#new_album_title').val('');
    if(!$('#upload_finish_wrapper').is('.is_visible')) {
        $('#upload_button_wrapper').removeClass('disabled');
    }
    Album.initUploadForm();
};

Album.initUploadForm = function() {
    if($('#log').children('li').not('.upload-done').not('.upload-error').size() == 0) {
        initForm();
    } else {
        setTimeout(function() {Album.initUploadForm()}, 500);
    }
}

Album.changeAlbumTitle = function(input) {
    if($(input).val() != '') {
        if($('#upload_finish_wrapper').not('.is_visible')) {
            $('#upload_button_wrapper').removeClass('disabled');
        }
        $('#album_select_chzn .search-choice-close').trigger('mouseup');
        upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/0/text/' + $(input).val() + '/u/' + $('#author_id').val() + '/');
        Album.initUploadForm();
    } else {
        clearFlash();
        $('#upload_button_wrapper').addClass('disabled');
    }

};

Album.changeTitle = function(link, id) {
    var span = $(link).parent().find('.album_title');
    var text = span.text();
    span.empty().append($('<input type="text" name="title_input" value="'+text+'" /><input type="hidden" name="album_id" value="'+id+'" /><button class="btn btn-green-small" onclick="return Album.appendTitle(this);"><span><span>Ок</span></span></button>'));
    $(link).hide();
    return false;
};
Album.appendTitle = function(button) {
    $(button).parent().parent().parent().children('a.edit').show();
    var span = $(button).parent();
    var text = span.find('input[name=title_input]').val();
    var id = span.find('input[name=album_id]').val();
    span.empty().text(text);
    $.post(base_url + '/albums/changeTitle/', {title : text, id : id});
    return false;
}

Album.changePhotoTitle = function(link, id) {
    var span = $(link).parent().find('.album_title');
    var text = span.text();
    if(text == '...')
        text = '';
    span.empty().append($('<input type="text" name="title_input" value="'+text+'" />&nbsp;<input type="hidden" name="album_id" value="'+id+'" /><button class="btn btn-green-small" onclick="return Album.appendPhotoTitle(this);"><span><span>Ок</span></span></button>'));
    $(link).hide();
    return false;
};
Album.appendPhotoTitle = function(button) {
    $(button).parent().parent().children('a.edit').show();
    var span = $(button).parent();
    var text = span.find('input[name=title_input]').val();
    var id = span.find('input[name=album_id]').val();
    $.post(base_url + '/albums/editPhotoTitle/', {title : text, id : id});
    if(text == '')
        text = '...';
    span.empty().text(text);
    return false;
}