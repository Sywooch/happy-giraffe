/**
 * Author: alexk984
 * Date: 26.03.12
 * Time: 15:05
 */
var UserLocation = {
    SelectCounty:function (elem) {
        UserLocation.clearCity();
        $.ajax({
            url:'/geo/regions/',
            data:{id:elem.val()},
            type:'POST',
            success:function (response) {
                if (response == ""){
                    $('div.settlement').hide();
                    $('#location-region').hide();
                    $('#first_steps_region').hide();
                    $('select#region_id').val('');

                }else{
                    $('#location-region').show();
                    $('#first_steps_region').show();

                    $('#region_id').html(response);
                    $('#first_steps_region_id').html(response);

                    $("#region_id").trigger("liszt:updated");
                    $("#first_steps_region_id").trigger("liszt:updated");
                }
            }
        });
    },
    RegionChanged:function (elem) {
        UserLocation.clearCity();
        $.ajax({
            url:'/geo/regionIsCity/',
            data:{id:elem.val()},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response != null) {
                    if (response.status)
                        $('div.settlement').hide();
                    else
                        $('div.settlement').show();
                }
            }
        });
    },
    clearCity:function () {
        $("#city_name").val('');
        $("#city_id").val('');

        $("#first_steps_city_name").val('');
        $("#first_steps_city_id").val('');
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
                    $.fancybox.close();
                    $('div.weather-wrapper').html(response.weather);
                    $('div.user-name div.location').html(response.location);
                    $("#loc-flipbox").flip({
                        direction:'rl',
                        speed:400,
                        color:'#fff',
                        content:response.main
                    });
                }
            }
        });
    },
    OpenEdit:function (elem) {
        $.ajax({
            url: '/geo/locationForm/',
            type: 'POST',
            success: function(response) {
                $("#loc-flipbox").flip({
                    direction:'rl',
                    speed:400,
                    color:'#fff',
                    content:response,
                    onEnd: function(){
                        $('#loc-flipbox .chzn').chosen();
                    }
                })
            }
        });
    }
}