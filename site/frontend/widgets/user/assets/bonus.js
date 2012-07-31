var Bonus = {
    setBirthday:function(){
        $.post('/ajax/birthday/', $('#birthday-form').serialize(), function(response) {
            if (response.status){
                Bonus.showBirthday(response.text);
                $.fancybox.close();
            }
        }, 'json');
    },
    showBirthday:function(text){
        $('.user-name .birthday').html(text);
        //$('.steps-list ul li:eq(1) .done').html('<i class=\"icon\"></i>Сделано');
        window.location.reload();
    },
    saveLocation:function(){
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
                    window.location.reload();
//                    $.fancybox.close();
//                    $('div.weather-wrapper').html(response.weather);
//                    $('div.user-name div.location').html(response.location);
//                    $('.steps-list ul li:eq(2) .done').html('<i class=\"icon\"></i>Сделано');
//                    $("#loc-flipbox").html(response.main);
                }
            }
        });
    }
}

