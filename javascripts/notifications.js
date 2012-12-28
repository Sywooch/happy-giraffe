var Notifications = {

}

Notifications.open = function() {
    Popup.load('Notifications');
    $.get('/userPopup/notifications/', function(data) {
        $('#popup-preloader').hide();
        $('.popup-container').append(data);
        $('.top-line-menu_nav_ul .i-notifications').addClass('active');
        Notifications.setHeight();
        $(window).on('resize', function() {
            Notifications.setHeight();
        });

    });
}

Notifications.close = function() {
    $('#user-notifications').remove();
    Popup.unload();
    $('.top-line-menu_nav_ul .i-notifications').removeClass('active');
    $(window).off('resize');
}

Notifications.toggle = function() {
    (this.isActive()) ? this.close() : this.open();
}

Notifications.isActive = function() {
    return $('#user-notifications:visible').length > 0;
}

Notifications.del = function(el, id) {
    var li = $(el).parents('li');
    $.post('/notification/delete2/', {id: id}, function(response) {
        if (response == 1) {
            Notifications.updateCounter(-1);
            $.fn.yiiListView.update('notificationsList');
        }
    });
}

Notifications.updateCounter = function(diff) {
    var li = $('.top-line-menu_nav_ul .i-notifications');
    var counter = li.find('.count span.count-red');
    var newVal = parseInt(counter.text()) + diff;

    counter.text(newVal);
    li.toggleClass('new', newVal != 0);
}

Notifications.setHeight = function() {
    var box = $('#user-notifications');

    var windowH = $(window).height();
    var headerH = 90;

    var marginH = 30;

    var generalH = windowH - marginH*3 - headerH;
    if (generalH < 400) generalH = 400;

    box.find('.notifications ul').css('max-height', generalH);
}

$(function() {
    Comet.prototype.receiveNotification = function(result, id) {
        Notifications.updateCounter(1);
        if (Notifications.isActive())
            $(result.html).hide().prependTo('#notificationsList .items').fadeIn();
    }

    comet.addEvent(1000, 'receiveNotification');
});

