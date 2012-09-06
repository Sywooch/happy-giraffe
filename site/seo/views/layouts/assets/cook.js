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
    },
    addTask:function (el, author_id) {
        var urls = new Array();
        $(el).parents('tr').find('input.example').each(function (index, val) {
            if ($(this).val() != '')
                urls.push($(this).val());
        });

        var multivarka = 0;
        if ($(el).parents('tr').find('input[name="multivarka"]').attr("checked") == "checked")
            multivarka = 1;
        var key_id = $(el).parents('tr').data('key_id');
        var task_id = $(el).parents('tr').data('task_id');

        $.post('/cook/cook/addTask/', {
            author_id:author_id,
            urls:urls,
            multivarka:multivarka,
            key_id:key_id,
            task_id:task_id
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.current-tasks tbody').append(response.html);
                TaskDistribution.group = new Array();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });

        }, 'json');
        return false;
    },
    returnTask:function (el) {
        $.post('/cook/cook/returnTask/', {id:$(el).parent('td').data('id')}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.table-cook tbody').append(response.html);
            }
        }, 'json');
    }
}
