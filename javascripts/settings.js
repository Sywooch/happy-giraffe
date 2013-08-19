var Settings = {

}

Settings.showInput = function(el) {
    $(el).parents('.form-settings_elem').find('div:first').toggleClass('display-n').next().toggleClass('display-n');
}

Settings.saveInput = function(el, attribute) {
    var val = $(el).prev().find('input').val();
    $.post('/user/settings/setValue/', {
        attribute: attribute,
        value: val
    }, function(response) {
        $(el).find('.form-settings_name').html(val);
        $(el).find('.form-settings_name').html(val);
        $(el).parents('.form-settings_elem').find('div:first').toggleClass('display-n').next().toggleClass('display-n');
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
