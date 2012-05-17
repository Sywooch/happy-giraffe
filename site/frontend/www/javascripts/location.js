/**
 * Author: alexk984
 * Date: 26.03.12
 * Time: 15:05
 */
var UserLocation = {
    SelectCounty:function (elem) {
        this.clearCity();
        $.ajax({
            url:'/geo/geo/regions/',
            data:{id:elem.val()},
            type:'POST',
            success:function (response) {
                $('#region_id').html(response);
                $("#region_id").trigger("liszt:updated");
            }
        });
    },
    RegionChanged:function (elem) {
        this.clearCity();
        $.ajax({
            url:'/geo/geo/regionIsCity/',
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
    },
    saveLocation:function () {
        $.ajax({
            url:'/geo/geo/saveLocation/',
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
                        content:response.main,
                    });
                }
            }
        });
    },
    OpenEdit:function (elem) {
        if(typeof(HMap.map.descruction) != 'undefined')
            HMap.map.descruction();
        if(typeof(HMap.map.destroy) != 'undefined')
            HMap.map.destroy();
        $.ajax({
            url: '/geo/geo/locationForm/',
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