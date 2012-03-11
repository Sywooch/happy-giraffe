$(function() {
    $('#notifications').delegate('a', 'click', function() {
        $('#notifications > ul').toggle();
    });
    $.ajax({
        dataType: 'json',
        url: '/notification/getLast/',
        success: function(response) {
            updateNotifications(response.count, response.data);
        }
    });
});

function updateNotifications(count, data)
{
    $('#notifications > span').text(count);
    $('#notifications > ul').html($('#notificationTmpl').tmpl(data));
}

Comet.prototype.updateNotifications = function(result, id) {
    updateNotifications(result.count, result.data);
}

comet.addEvent(100, 'updateNotifications');