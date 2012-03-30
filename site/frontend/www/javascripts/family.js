var Family = {
    setStatusRadio:function (el) {
        $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
        $(el).addClass('checked').find('input').attr('checked', 'checked');
    }
}
