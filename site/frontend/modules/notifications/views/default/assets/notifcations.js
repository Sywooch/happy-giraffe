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
                        UserNotification.updateCounter(-count);
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
    loadMore: function (url) {
        if (!UserNotification.loading) {
            UserNotification.loading = true;
            UserNotification.page++;
            $.post('?page=' + UserNotification.page, function (response) {
                if (response == '') {
                    UserNotification.disableLoading();
                } else {
                    $('#user-notice-list_inner').append(response);
                    UserNotification.loading = false;
                }
            });
        }
    },
    disableLoading: function () {
        UserNotification.loading = true;
        $('.user-notice-list #infscr-loading').hide();
    },
    updateCounter: function (diff) {
        var li = $('.top-line-menu_nav_ul .i-notifications');
        var counter = li.find('.count span.count-red');
        var newVal = parseInt(counter.text()) + diff;

        counter.text(newVal);
        li.toggleClass('new', newVal != 0);
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
    $('.layout-container').scroll(function () {
        if (($('#user-notice-list_inner').height() - 500) < $(this).scrollTop())
            UserNotification.loadMore();
    });

    Comet.prototype.receiveNotification = function(result, id) {
        UserNotification.updateCounter(result.count);
    };

    comet.addEvent(1000, 'receiveNotification');
});