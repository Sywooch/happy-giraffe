var Messages = {

}

Messages.setList = function(type) {
    $.get('/im/contacts/', {type: type}, function(data) {
        $('#user-dialogs-contacts').html(data);
    });
    $('#user-dialogs-nav li.active').removeClass('active');
    $('#user-dialogs-nav li:eq(' + type + ')').addClass('active');
}

$(function() {
    Messages.setList(0);
});
