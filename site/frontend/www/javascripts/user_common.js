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

    $('body').delegate('div.user-weather #forecast-link', 'click', function(){
        $('#today-weather').fadeOut(250, function(){
            $('#forecast').fadeIn(250);
        });
        return false;
    });

    $('body').delegate('div.user-weather #today-link', 'click', function(){
        $('#forecast').fadeOut(250, function(){
            $('#today-weather').fadeIn(250);
        });
        return false;
    });

    $('#change_ava').delegate('a.renew', 'click', function() {
        $('#change_ava > div.photo > a').trigger('click');
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

function sendInvite(el, user_id) {
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: '/friendRequests/send/',
        data: {
            to_id: user_id
        },
        success: function (response) {
            if (response.status) {
                $(el).replaceWith(response.html);
            }
        }
    });

}

function deleteFriend(el, user_id, friendPage) {
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: '/friendRequests/delete/',
        data: {
            friend_id: user_id
        },
        success: function (response) {
            if (response.status) {
                (friendPage) ? $.fn.yiiListView.update('friends') : $(el).replaceWith(response.html);
            }
        }
    });
}