/**
 * Author: alexk984
 * Date: 24.08.12
 */

Comet.prototype.CommentatorPanelUpdate = function (result, id) {
    switch (result.update_part) {
        case 1:
            CommentatorPanel.updateBlog();
            break;
        case 2:
            CommentatorPanel.updateClub();
            break;
        case 3:
            CommentatorPanel.updateComments();
            break;
    }
}

var CommentatorPanel = {
    updateBlog:function () {
        $.post('/signal/commentator/blog/', function (response) {
            $('#blog-posts').html(response);
        });
    },
    updateClub:function () {
        $.post('/signal/commentator/club/', function (response) {
            $('#club-posts').html(response);
        });
    },
    updateComments:function () {
        $.post('/signal/commentator/comments/', function (response) {
            $('#comments').html(response);
        });
    }
}

$(function () {
    comet.addEvent(9, 'CommentatorPanelUpdate');

    CommentatorPanel.updateBlog();
    CommentatorPanel.updateClub();
    CommentatorPanel.updateComments();
});