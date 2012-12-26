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
        $('div.horoscope-wrapper').html(response.horoscope);
        Bonus.closeStep(1);
        $.fancybox.close();
    },
    closeStep:function(i){
        $('.steps-list ul li:eq('+i+') div.done').html('<i class=\"icon\"></i>Сделано');
        $('.steps-list ul li:eq('+i+')').addClass('strike');
        $('.steps-list ul li:eq('+i+') div.text').html($('.steps-list ul li:eq('+i+') div.text').text());
    },
    saveLocation:function () {
        $.ajax({
            url:'/geo/saveLocation/',
            data:{
                country_id:$('#first_steps_country_id').val(),
                city_id:$('#first_steps_city_id').val(),
                region_id:$('#first_steps_region_id').val()
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    if (response.full)
                        window.location.reload();

                    Bonus.closeStep(2);
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

