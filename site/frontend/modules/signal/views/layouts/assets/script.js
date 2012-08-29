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
    updateByName:function(name){
        $.post('/signal/commentator/' + name + '/', function (response) {
            $('#block-' + name).html(response);
        });
    },
    iAmWorking:function(){
        window.location.href = '/signal/commentator/iAmWorking/';
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');
});