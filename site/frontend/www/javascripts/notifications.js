var Notifications = {

}

Notifications.open = function() {
    $.get('/userPopup/notifications', function(data) {
        $('body').append(data);
        $('body').css('overflow', 'hidden');
        $('body').append('<div id="body-overlay"></div>');
        $('body').addClass('nav-fixed');
        $('#user-nav-notifications').addClass('active');
        Notifications.setHeight();
        $(window).on('resize', function() {
            Notifications.setHeight();
        });
    });
}

Notifications.close = function() {
    $('#user-notifications').remove();
    $('body').css('overflow', '');
    $('#body-overlay').remove();
    $('body').removeClass('nav-fixed');
    $('#user-nav-notifications').removeClass('active');
    $(window).off('resize');
}

Notifications.toggle = function() {
    (this.isActive()) ? this.close() : this.open();
}

Notifications.isActive = function() {
    return $('#user-notifications:visible').length > 0;
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