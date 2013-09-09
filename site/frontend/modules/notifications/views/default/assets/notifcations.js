/**
 * @author Alex Kireev <alexk984@gmail.com>
 * Date: 16.05.13
 */

var UserNotification = {
    stop: false,
    page: 0,
    loading: false,
    read: function (el, id, count) {
        $.post('/notifications/readOne/', {id: id}, function (response) {
            if (response.status) {
                $(el).parent().hide();
                $(el).parent().next().show();

                UserNotification.stop = false;
                setTimeout(function () {
                    if (!UserNotification.stop) {
                        $(el).parents('.user-notice-list_i').fadeOut(1000);
                        NotificationsUpdateCounter(-1);
                    }
                }, 3000);
            }
        }, 'json');
    },
    readAll: function () {
        $.post('/notifications/readAll/', function (response) {
            if (response.status) {
                UserNotification.disableLoading();
                $('.user-notice-list_i').fadeOut(1000);
                UserNotification.hideCounter();
            }
        }, 'json');
    },
    cancel: function (el, id, count) {
        UserNotification.stop = true;
        $.post('/notifications/unread/', {id: id}, function (response) {
            if (response.status) {
                $(el).parent().parent().hide();
                $(el).parent().parent().prev().show();
                $(el).parents('.user-notice-list_i').show();
            }
        }, 'json');
    },
    loadMore: function () {
        if (!UserNotification.loading) {
            UserNotification.loading = true;
            UserNotification.page++;
            $.post('?page=' + UserNotification.page, function (response) {
                if (response.empty) {
                    UserNotification.disableLoading();
                } else {
                    $('#user-notice-list_inner').append(response.html);
                    UserNotification.loading = false;
                }
            }, 'json');
        }
    },
    disableLoading: function () {
        UserNotification.loading = true;
        $('.user-notice-list #infscr-loading').hide();
    },
    hideCounter: function () {
        var li = $('.top-line-menu_nav_ul .i-notifications');
        var counter = li.find('.count span.count-red');
        var newVal = 0;

        counter.text(newVal);
        li.toggleClass('new', newVal != 0);
    }
};

$(function () {
    $(window).scroll(function () {
        if (($('#user-notice-list_inner').height() - 1000) < $(this).scrollTop())
            UserNotification.loadMore();
    });
});