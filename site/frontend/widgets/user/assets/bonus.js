var Bonus = {
    setBirthday:function () {
        $.post('/ajax/birthday/', $('#birthday-form').serialize(), function (response) {
            if (response.status) {
                Bonus.showBirthday(response);
                $.fancybox.close();
            }
        }, 'json');
    },
    showBirthday:function (response) {
        if (response.full)
            window.location.reload();
        $('.user-name .birthday').html(response.text);
        $('.steps-list ul li:eq(1) div.done').html('<i class=\"icon\"></i>Сделано');
        $('div.horoscope-wrapper').html(response.horoscope);
        $.fancybox.close();
    },
    saveLocation:function () {
        $.ajax({
            url:'/geo/saveLocation/',
            data:{
                country_id:$('#country_id').val(),
                city_id:$('#city_id').val(),
                region_id:$('#region_id').val()
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    if (response.full)
                        window.location.reload();

                    $('.steps-list ul li:eq(2) div.done').html('<i class=\"icon\"></i>Сделано');
                    $.fancybox.close();
                    $('div.weather-wrapper').html(response.weather);
                    $('div.user-name div.location').html(response.location);
                    $("#loc-flipbox").html(response.main);
                }
            }
        });
    },
    sendConfirmEmail:function () {
        $.post('/site/resendConfirmEmail/', function (response) {
            $.fancybox.close();
        });
    }
}

