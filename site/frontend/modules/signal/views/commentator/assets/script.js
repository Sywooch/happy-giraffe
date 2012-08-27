/**
 * Author: alexk984
 * Date: 24.08.12
 */

Comet.prototype.CommentatorPanelUpdate = function (result, id) {
    if (CommentatorPanel.blocks[result.update_part] == 'comments') {
        console.log(result);
        $('#block-comments .inner').prepend(result.link);

        var found = false;
        $('#block-posts a').each(function (index, element) {
            if (!found && $(this).data('entity') == result.entity && $(this).data('entity_id') == result.entity_id) {
                found = true;
                console.log(true);
                CommentatorPanel.updateByName('posts');
            }
        });

        if (!found)
            $('#block-additionalPosts a').each(function (index, element) {
                if (!found && $(this).data('entity') == result.entity && $(this).data('entity_id') == result.entity_id) {
                    found = true;
                    CommentatorPanel.updateByName('additionalPosts');
                }
            });
    } else
        CommentatorPanel.update(result.update_part);
}

var CommentatorPanel = {
    blocks:['blog', 'club', 'comments', 'posts', 'additionalPosts'],
    timer:null,
    update:function (block) {
        CommentatorPanel.updateByName(CommentatorPanel.blocks[block]);
    },
    updateByName:function(name){
        $.post('/signal/commentator/' + name + '/', function (response) {
            $('#block-' + name).html(response);
        });
    },
    AutoUpdate:function(){
        console.log('update');
        CommentatorPanel.updateByName('posts');
        CommentatorPanel.updateByName('additionalPosts');
        CommentatorPanel.timer = window.setTimeout("CommentatorPanel.AutoUpdate()", 300000);
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');

    for (var key in CommentatorPanel.blocks) {
        CommentatorPanel.update(key);
    }

    CommentatorPanel.timer = window.setTimeout("CommentatorPanel.AutoUpdate()", 300000);
});