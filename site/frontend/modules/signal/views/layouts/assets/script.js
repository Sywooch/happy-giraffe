/**
 * Author: alexk984
 * Date: 24.08.12
 */

Comet.prototype.CommentatorPanelUpdate = function (result, id) {
    CommentatorPanel.update(result.update_part);
}

var CommentatorPanel = {
    blocks:['blog', 'club', 'comments', 'posts', 'additionalPosts'],
    timer:null,
    update:function (block) {
        CommentatorPanel.updateByName(CommentatorPanel.blocks[block]);
    },
    updateByName:function (name) {
        $.post('/signal/commentator/' + name + '/', function (response) {
            $('#block-' + name).html(response);
        });
    },
    iAmWorking:function () {
        window.location.href = '/signal/commentator/iAmWorking/';
    },
    skip:function () {
        $.post('/signal/commentator/skip/', function (response) {
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
    show:function(id, el){
        $('#'+id).toggle();

        if ($(el).text() == 'Показать')
            $(el).text('Скрыть');
        else
            $(el).text('Показать');
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');
});