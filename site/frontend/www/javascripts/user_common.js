$(function() {
    $.ajax({
        dataType: 'json',
        url: '/notification/getLast/',
        success: function(response) {
            updateNotifications(response.notifications.count, response.notifications.data);
            updateFriends(response.friends.count, response.friends.data);
            updateIm(response.im.count, response.im.data);
        }
    });

    $('#user-nav-friends').delegate('i.close', 'click', function(e) {
        e.preventDefault();
        var el = $(this).closest('li');
        var id = el.attr('id');
        $.ajax({
            type: 'post',
            url: '/notification/delete/',
            data: {
                id: id
            },
            success: function(response) {
                if (response) {
                    el.remove();

                }
            }
        })
    });
});

function updateNotifications(count, data)
{
    $('#user-nav-notifications span.count').text(count).toggle(count != 0);
    $('#user-nav-notifications ul.list').html($('#notificationTmpl').tmpl(data));
}

function updateFriends(count, data, invite)
{
    $('#user-nav-friends span.count').text(count).toggle(count != 0);
    $('#user-nav-friends ul.list').html($('#friendNotificationTmpl').tmpl(data));
    if (invite) {
        var el = $('#user-nav-friends a.count');
        var c = parseInt(el.text()) + 1;
        el.text(c).toggleClass('count-gray', c == 0);
    }
}

function updateIm(count, data)
{
    $('#user-nav-messages span.count').text(count).toggle(count != 0);
    $('#user-nav-messages ul.list').html($('#imNotificationTmpl').tmpl(data));
}

Comet.prototype.updateNotifications = function(result, id) {
    updateNotifications(result.count, result.data);
}

Comet.prototype.updateFriends = function(result, id) {
    updateFriends(result.count, result.data, result.invite);
}

comet.addEvent(100, 'updateNotifications');
comet.addEvent(101, 'updateFriends');