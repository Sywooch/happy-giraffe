var Settings = {

}

Settings.open = function() {
    $.get('/userPopup/settings', function(data) {
        $('body').append(data);
        $('body').css('overflow', 'hidden');
        $('body').append('<div id="body-overlay"></div>');
        $('body').addClass('nav-fixed');
        $('#user-nav-settings').addClass('active');
        Settings.openTab(0);
    });
}

Settings.close = function() {
    $('#user-settings').remove();
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

Settings.openTab = function(index) {
    $('#user-settings .nav ul li.active').removeClass('active');
    $('#user-settings .settings-in:visible').hide();
    $('#user-settings .nav ul li:eq(' + index + ')').addClass('active')
    $('#user-settings .settings-in:eq(' + index + ')').show();
}

Settings.changePassword = function(form) {
    $.post($(form).attr('action'), $(form).serialize(), function(data) {
        if (data == 'true') {
            $(form).find('input:text').val('');
            $('.refresh').trigger('click');
        }
    });
}