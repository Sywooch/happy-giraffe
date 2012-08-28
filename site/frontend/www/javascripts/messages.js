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
        $('#user-dialogs-dialog').html(data.html);
        $('#user-dialogs-dialog').data('dialogid', data.dialogid);
        $('#user-dialogs-dialog').data('interlocutorid', interlocutor_id);
        $('#user-dialogs-contacts li.active').removeClass('active');
        $('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]').addClass('active');
        setMessagesHeight();
        Messages.scrollDown();
    }, 'json');
}

Messages.sendMessage = function(form) {
    var values = $(form).serialize();
    values += "&interlocutor_id=" + encodeURIComponent($('#user-dialogs-dialog').data('interlocutorid'));
    $.post($(form).attr('action'), values, function(data) {
        if (data.status == 1) {
            form.reset();
            $('.dialog-messages > ul').append(data.html);
            Messages.scrollDown();
        }
    }, 'json');
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

Messages.scrollDown = function() {
    $(".dialog-messages").prop('scrollTop', $(".dialog-messages").prop("scrollHeight"));
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

Comet.prototype.receiveMessage = function (result, id) {
    if (result.from == $('#user-dialogs-dialog').data('interlocutorid')) {
        $('.dialog-messages > ul').append(result.html);
        Messages.scrollDown();
    }
}
comet.addEvent(1, 'receiveMessage');

$(function() {
    Messages.setList(0);
});
