var Messages = {

}

Messages.setList = function(type) {
    $.get('/im/contacts/', {type: type}, function(data) {
        $('#user-dialogs-contacts').html(data);
        $('#user-dialogs-nav li.active').removeClass('active');
        $('#user-dialogs-nav li:eq(' + type + ')').addClass('active');

        Messages.setDialog($('#user-dialogs-contacts > li:first').data('userid'));
    });
}

Messages.setDialog = function(interlocutor_id) {
    $.get('/im/dialog/', {interlocutor_id: interlocutor_id}, function(data) {
        $('#user-dialogs-dialog').html(data);
        $('#user-dialogs-contacts li.active').removeClass('active');
        $('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]').addClass('active');
    });
}

Messages.updateCounter = function(selector, diff) {
    var newValue = parseInt($(selector).text()) + diff;
    $(selector).text(newValue);
    if (newValue == 0) {
        $(selector).parents('li').addClass('disabled');
    } else {
        if ($(selector).parents('li').hasClass('disabled'))
            $(selector).parents('li').removeClass('disabled');
    }
}

Messages.filterList = function(filter) {
    if (filter) {
        $('#user-dialogs-contacts').find("span.username:not(:Contains(" + filter + "))").parents('li').slideUp();
        $('#user-dialogs-contacts').find("span.username:Contains(" + filter + ")").parents('li').slideDown();
    } else {
        $('#user-dialogs-contacts > li').slideDown();
    }
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
