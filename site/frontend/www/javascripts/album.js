var Album = {};
Album.editDescription = function (link) {
    var note = $(link).parents('.note:eq(0)');
    $('.fast-actions', note).hide();
    var html = $('<form><textarea placeholder="Введите комментарий к альбому не более 140 символов"></textarea><button class="btn btn-green-small"><span><span>Ок</span></span></button></form>');
    $('textarea', html).val($('p', note).text());
    $('p', note).remove();
    html.appendTo(note);
    $('form', note).bind('submit', function () {
        Album.saveDescription(this);
        return false;
    });
    return false;
};

Album.saveDescription = function (button) {
    var note = $(button).parents('.note:eq(0)');
    var text = $('textarea', note).val();
    $('<p></p>').text(text).appendTo(note);
    $('form', note).remove();
    $('.fast-actions', note).show();
    $.post($('.fast-actions a.edit', note).attr('href'), {text : text})
};

Album.removeDescription = function(link) {
    $.post(link.href, {text : ''});
    $(link).parents('.note:eq(0)').remove();
    return false;
}
