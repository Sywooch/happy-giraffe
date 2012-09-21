var Settings = {
    entity: null,
    entity_id: null
}

Settings.open = function() {
    $.get('/settings/', function(data) {
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

Settings.showInput = function(el) {
    $(el).parents('.row-elements').find('.value').hide();
    $(el).parents('.row-elements').find('.input').show();
}

Settings.saveInput = function(el, attribute) {
    $.post('/ajax/setValue/', {
        entity: Settings.entity,
        entity_id: Settings.entity_id,
        attribute: attribute,
        value: $(el).prev().val()
    }, function(response) {
        if (response) {
            $(el).parents('.row-elements').find('.input').hide();
            $(el).parents('.row-elements').find('.value').show();
            $(el).parents('.row-elements').find('.value span').text($(el).prev().val());
        }
    });
}

Settings.changePassword = function(form) {
    $.post($(form).attr('action'), $(form).serialize(), function(data) {
        if (data == 'true') {
            $(form).find('input:text, input:password').val('');
            $('.refresh').trigger('click');
        }
    });
}

Settings.changeGender = function(el) {
    $.post('/ajax/setValue/', {
        entity: Settings.entity,
        entity_id: Settings.entity_id,
        attribute: 'gender',
        value: $(el).val()
    });
}