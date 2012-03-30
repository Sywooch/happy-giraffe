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
    var text = $(link).siblings('span').text();
    $(link).parent().hide().siblings('div').show().find('input[type=text]').val(text);
    return false;
};

/* Сохранение названия фотографии */
Album.savePhoto = function (button) {
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
        if($('#new_album_title').val() == '')
            $('#upload_button_wrapper').hide();
        return false;
    }
    this.album_id = $(select).val();

    upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/' + $(select).val() + '/');
    initForm();
    $('#new_album_title').val('');
    $('#upload_button_wrapper').show();
};

Album.changeAlbumTitle = function(input) {
    if($(input).val() != '') {
        $('#upload_button_wrapper').show();
        $('#album_select_chzn .search-choice-close').trigger('mouseup');
        upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/0/text/' + $(input).val() + '/u/' + $('#author_id').val() + '/');
        initForm();
    } else {
        $('#upload_button_wrapper').hide();
    }

}