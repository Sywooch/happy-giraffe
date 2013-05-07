/**
 * Author: alexk984
 * Date: 05.09.12
 */
var CookModule = {
    section:2,
    addTaskByName:function () {
        $.post('/cook/editor/addByName/', $('#add-by-name').serialize(), function (response) {
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

                $('.cook-recipes-today ol').append('<li>' + response.title + '</li>');
                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) + 1);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Введите название рецепта'
                });
            }
        }, 'json');
    },
    addTask:function (el, author_id, section) {
        var urls = [];
        $(el).parents('tr').find('input.example').each(function (index, val) {
            if ($(this).val() != '')
                urls.push($(this).val());
        });

        var sub_section = 0;
        if ($(el).parents('tr').find('input[name="sub_section"]').attr("checked") == "checked")
            sub_section = 1;
        var key_id = $(el).parents('tr').data('key_id');
        var task_id = $(el).parents('tr').data('task_id');

        $.post('/cook/editor/addTask/', {
            author_id:author_id,
            urls:urls,
            sub_section:sub_section,
            key_id:key_id,
            task_id:task_id,
            section:section
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.current-tasks tbody').append(response.html);
                TaskDistribution.group = [];
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
        $.post('/cook/editor/returnTask/', {id:$(el).parent('td').data('id')}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.table-cook tbody').append(response.html);
            }
        }, 'json');
    },
    written:function (id, el) {
        $.post('/cook/author/executed/', {id:id, name:$(el).prev().val()}, function (response) {
            if (response.status) {
                document.location.reload();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    toPublishing:function (el, id) {
        $.post('/writing/editor/publish/', {id:id}, function (response) {
            if (response.status) {
                var row = $(el).parents('tr');
                $(el).parents('td').addClass('seo-status-publish-2').text('На публикации');

                $('#publish-table').append(row.remove());
                calcTaskCount();
            }
        }, 'json');
    },
    publish:function(el, id){
        if ($(el).prev().val() !== "")
            $.post('/cook/content/publish/', {id:id, url:$(el).prev().val()}, function (response) {
                if (response.status) {
                    $(el).parents('tr').remove();
                } else {
                    if (response.errorText !== undefined)
                        $.pnotify({
                            pnotify_title:'Ошибка',
                            pnotify_type:'error',
                            pnotify_text:response.errorText
                        });
                    else
                        $.pnotify({
                            pnotify_title:'Ошибка',
                            pnotify_type:'error',
                            pnotify_text:response.error
                        });
                }
            }, 'json');
        else
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Введите url статьи'
            });
    },
    changeSection:function(el, task_id, section){
        $.post('/cook/editor/changeSection/', {
            task_id:task_id,
            section:section
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error'
                });
            }
        }, 'json');
    }
}
