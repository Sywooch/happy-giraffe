var Messages = {

}

Messages.setList = function(type) {
    $.get('/im/contacts/', {type: type}, function(data) {
        $('#user-dialogs-contacts').html(data);
    });
    $('#user-dialogs-nav li.active').removeClass('active');
    $('#user-dialogs-nav li:eq(' + type + ')').addClass('active');
}

Comet.prototype.updateStatus = function (result, id) {
    var indicators = $('[data-userid=' + result.user_id +'] .icon-status');
    if (result.online == 1) {
        indicators.removeClass('status-offline').addClass('status-online');
    } else {
        indicators.removeClass('status-online').addClass('status-offline');
    }
}
comet.addEvent(3, 'updateStatus');

$(function() {
    Messages.setList(0);
});
