/**
 * Author: alexk984
 * Date: 15.09.12
 */
function setTab(el, num) {
    var tabs = $(el).parents('.tabs');
    var li = $(el).parent();
    if (!li.hasClass('active')) {
        tabs.find('li').removeClass('active');
        li.addClass('active');
        tabs.find('.tab-box-' + num).fadeIn();
        tabs.find('.tab-box').not('.tab-box-' + num).hide();

    }
}

function ShowHide(el, id, show_title, hide_title) {

    if (show_title == undefined)
        show_title = 'Показать';
    if (hide_title == undefined)
        hide_title = 'Скрыть';

    $('#' + id).toggle();

    if ($(el).text() == show_title)
        $(el).text(hide_title);
    else
        $(el).text(show_title);
}

function SaveSettings(el, reload) {
    $.post('/promotion/linking/saveSettings/', $(el).parents('form').serialize(), function (response) {
        if (response.status) {
            if (reload)
                location.reload();
            else
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Настройки изменены'
                });
        }
    }, 'json');
}

function CheckboxNext(el) {
    console.log($(el).is(':checked'));
    if ($(el).is(':checked'))
        $(el).next().val(1);
    else
        $(el).next().val(0);
}