/**
 * User: alexk984
 * Date: 14.03.12
 */
var im = new Im;

Comet.prototype.NewMessage = function (result, id) {
    if (window.ShowNewMessage) {
        ShowNewMessage(result);
        if (result.dialog_id != dialog) {
            im.ShowMiniMessage(result);
        }
    }
    else {
        im.ShowMiniMessage(result);
    }
}
Comet.prototype.ShowChangeStatus = function (result, id) {
    if (window.StatusChanged)
        StatusChanged(result);
    im.OnlineCount(result);
}
comet.addEvent(1, 'NewMessage');
comet.addEvent(3, 'ShowChangeStatus');


function Im() {
    this.GetLastUrl = '';
}
Im.prototype.ShowMiniMessage = function (result) {
    im.ShowNewMessagesCount(result.unread_count);

    $.ajax({
        url:this.GetLastUrl,
        type:'POST',
        dataType:'JSON',
        success:function (response) {
            $('#user-nav-messages ul.list').html($('#imNotificationTmpl').tmpl(response.data));
        },
        context:$(this)
    });
}
Im.prototype.ShowNewMessagesCount = function (id) {
    if (id > 0) {
        $("#dialogs .header .count").show();
        $("#user-nav-messages > a > span.count").show();
    }
    else {
        $("#dialogs .header .count").hide();
        $("#user-nav-messages > a > span.count").hide();
    }
    $("#dialogs .header .count").html(id);
    $("#user-nav-messages > a > span.count").html(id);
    $("#user-nav-messages .drp .actions a.count").html(id);
}
Im.prototype.OnlineCount = function (result) {
    var i = -1;
    if (result.online == 1)
        i = 1;

    if (result.user_type == 0 || result.user_type == 2) {
        var el = $('#user-nav-messages span.online-count');
        var comment_count = el.text();
        var current_count = parseInt(comment_count) + i;
        el.text(current_count).toggleClass('count-gray', current_count == 0);
    }
    if (result.user_type == 1 || result.user_type == 2) {
        var el = $('#user-nav-friends span.online-count');
        var comment_count = el.text();
        var current_count = parseInt(comment_count) + i;

        el.text(current_count).toggleClass('count-gray', current_count == 0);
    }
}
