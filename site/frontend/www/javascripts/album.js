var Album = {
    editMode : false
};
Album.editDescription = function (link, tmp) {
    var note = $(link).parents('.note:eq(0)');
    $('.fast-actions', note).hide();
    if(!tmp) {
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
    if(tmp) {
        $('form', note).hide();
    } else {
        $('form', note).remove();
        $.post($('.fast-actions a.edit', note).attr('href'), {text : text});
    }
};

Album.removeDescription = function(link) {
    $.post(link.href, {text : ''});
    $(link).parents('.note:eq(0)').remove();
    return false;
};

/* Изменение названия фотографии */
Album.editPhoto = function(link) {
    var text = $(link).siblings('span').text();
    if(this.editMode) {
        $(link).parent().hide().siblings('div').show().find('input[type=text]').val(text);
    }
    return false;
};

/* Сохранение названия фотографии */
Album.savePhoto = function(button) {
    var text = $(button).siblings('input[type=text]').val();
    if(this.editMode) {
        $(button).parent().hide().siblings('div').show().find('span').text(text);
    }
    return false;
};