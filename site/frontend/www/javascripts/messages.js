var Messages = {

}

Messages.setList = function(type) {
    $.get('/im/contacts/', {type: type}, function(data) {
        $('#user-dialogs-contacts').html(data);
    });
    $('#user-dialogs-nav li.active').removeClass('active');
    $('#user-dialogs-nav li:eq(' + type + ')').addClass('active');
}

Messages.updateCounter = function(selector, diff) {
    $(selector).text(parseInt($(selector).text()) + diff);
}

Comet.prototype.updateStatus = function (result, id) {
    var indicators = $('[data-userid=' + result.user_id +'] .icon-status');
    if (result.online == 1) {
        indicators.removeClass('status-offline').addClass('status-online');
        Messages.updateCounter('#user-dialogs-onlineCount', 1);
        if (result.is_friend)
            Messages.updateCounter('#user-dialogs-friendsCount', 1);
    } else {
        indicators.removeClass('status-online').addClass('status-offline');
        Messages.updateCounter('#user-dialogs-onlineCount', -1);
        if (result.is_friend)
            Messages.updateCounter('#user-dialogs-friendsCount', -1);
    }
}
comet.addEvent(3, 'updateStatus');

$(function() {
    Messages.setList(0);
});
