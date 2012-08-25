/**
 * Author: alexk984
 * Date: 24.08.12
 */

Comet.prototype.CommentatorPanelUpdate = function (result, id) {
    CommentatorPanel.update(result.update_part);
}

var CommentatorPanel = {
    blocks:['blog','club', 'comments', 'posts', 'additionalPosts'],
    update:function (block) {
        var name = CommentatorPanel.blocks[block];
        $.post('/signal/commentator/'+name+'/', function (response) {
            $('#block-'+name).html(response);
        });
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');

    for (var key in CommentatorPanel.blocks) {
        CommentatorPanel.update(key);
    }
});