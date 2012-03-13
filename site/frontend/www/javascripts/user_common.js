$(function() {
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
    $('#user-nav-notifications span.count').text(count);
    $('#user-nav-notifications ul.list').html($('#notificationTmpl').tmpl(data));
}

Comet.prototype.updateNotifications = function(result, id) {
    updateNotifications(result.count, result.data);
}

comet.addEvent(100, 'updateNotifications');