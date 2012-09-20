var Settings = {

}

Settings.open = function() {
    $.get('/userPopup/settings', function(data) {
        $('body').append(data);
        $('body').css('overflow', 'hidden');
        $('body').append('<div id="body-overlay"></div>');
        $('body').addClass('nav-fixed');
        $('#user-nav-settings').addClass('active');
    });
}

Settings.close = function() {
    $('#user-notifications').remove();
    $('body').css('overflow', '');
    $('#body-overlay').remove();
    $('body').removeClass('nav-fixed');
    $('#user-nav-settings').removeClass('active');
}

Settings.toggle = function() {
    (this.isActive()) ? this.close() : this.open();
}

Settings.isActive = function() {
    return $('#user-settings:visible').length > 0;
}

Settings.switchTab = function() {

}