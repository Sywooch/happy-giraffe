/**
 * Author: alexk984
 * Date: 05.09.12
 */
var CookModule = {
    addTaskByName:function () {
        $.post('/cook/cook/addByName/', $('#add-by-name').serialize(), function (response) {
            if (response.status) {
                $('input.item-title').val('');
                $('#urls input').each(function (index, Element) {
                    if (index != 0)
                        $(this).remove();
                    else
                        $(this).val('');
                });
                $('#urls br').each(function (index, Element) {
                    if (index != 0)
                        $(this).remove();
                });

                $('.cook-recipes-today ol').append('<li>' + response.title + '</li>')
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Введите название рецепта'
                });
            }
        }, 'json');
    }
}
