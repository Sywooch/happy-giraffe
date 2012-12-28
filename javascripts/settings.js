var Settings = {
    entity: null,
    entity_id: null
}

Settings.open = function(tab) {
    tab = (typeof tab === "undefined") ? 0 : tab;

    Popup.load('Settings');
    $.get('/settings/', function(data) {
        $('#popup-preloader').hide();
        $('.popup-container').append(data);
        $('.top-line-menu_nav_ul .i-settings').addClass('active');
        Settings.openTab(tab);
        $('.chzn').each(function () {
            var $this = $(this);
            $this.chosen({
                allow_single_deselect:$this.hasClass('chzn-deselect')
            })
        });
    });
}

Settings.close = function() {
    Popup.unload();
    $('#user-settings').remove();
    $('body').removeClass('nav-fixed');
    $('.top-line-menu_nav_ul .i-settings').removeClass('active');
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
    $('#user-settings .nav ul li:eq(' + index + ')').addClass('active');
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

Settings.saveBirthday = function(el) {
    $.post('/ajax/setDate/', {
        entity: Settings.entity,
        entity_id: Settings.entity_id,
        attribute: 'birthday',
        d: $('#User_birthday_d').val(),
        m: $('#User_birthday_m').val(),
        y: $('#User_birthday_y').val()
    }, function(response) {
        if (response.status) {
            $(el).parents('.row-elements').find('.input').hide();
            $(el).parents('.row-elements').find('.value').show();
            $(el).parents('.row-elements').find('.value span').text(response.birthday_str);
        }
    }, 'json');
}

Settings.changePassword = function(form) {
    $.post($(form).attr('action'), $(form).serialize(), function(data) {
        if (data == 'true') {
            $(form).find('input:text, input:password').val('');
            $(form).find('span.success').show().fadeOut(5000);
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

Settings.removeService = function (el, id, service) {
    $.post('/settings/removeService/', {
        id: id
    }, function(response) {
        if (response == 'true') {
            $(el).parents('li').remove();
            $('.auth-services li.' + service).show();
            if ($('.profiles-list ul li').length == 0)
                $('.profiles-list').hide();
        }
    })
}


Settings.changeMailSub = function(el, name) {
    var value = 0 ;
    if ($(el).is(':checked'))
        value = 1;

    $.post('/ajax/setValue/', {
        entity: 'UserMailSub',
        entity_id: Settings.entity_id,
        attribute: name,
        value: value
    });
}
