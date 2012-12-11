/**
 * Author: alexk984
 * Date: 24.08.12
 */

Comet.prototype.CommentatorPanelUpdate = function (result, id) {
    CommentatorPanel.update(result.update_part);
}

var CommentatorPanel = {
    block:0,
    blocks:['blog', 'club', 'comments'],
    timer:null,
    update:function (block) {
        CommentatorPanel.updateByName(CommentatorPanel.blocks[block]);
    },
    updateByName:function (name) {
        $.post('/commentator/' + name + '/', function (response) {
            $('#block-' + name).html(response);
        });
    },
    iAmWorking:function () {
        window.location.href = '/commentator/iAmWorking/';
    },
    skip:function () {
        $.post('/commentator/skip/', function (response) {
            if (response.status)
                $('#block-comments').html(response.html);
            else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Можно пропустить не более 10 комментариев в день'
                });

        }, 'json');
    },
    show:function (id, el) {
        $('#' + id).toggle();

        if ($(el).text() == 'Показать')
            $(el).text('Скрыть');
        else
            $(el).text('Показать');
    },
    TakeTask:function (id) {
        $.post('/commentator/take/', {id:id,block:CommentatorPanel.block}, function (response) {
            if (response.status) {
                document.location.reload();
            }
            else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    Written:function (id, el) {
        $.post('/commentator/executed/', {id:id, url:$(el).prev().val()}, function (response) {
            if (response.status) {
                document.location.reload();
            }
            else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    CancelTask:function (id, el) {
        $.post('/commentator/cancelTask/', {id:id}, function (response) {
            if (response.status) {
                document.location.reload();
            }
            else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');
});