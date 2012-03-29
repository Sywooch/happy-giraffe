/**
 * Author: alexk984
 * Date: 26.03.12
 * Time: 15:05
 */
var UserLocation = {
    regionUrl:null,
    cityUrl:null,
    saveUrl:null,
    regionIsCityUrl:null,
    editFormUrl:null,
    SelectCounty:function (elem) {
        this.clearCity();
        $.ajax({
            url:this.regionUrl,
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
            url:this.regionIsCityUrl,
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
            url:this.saveUrl,
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
                        onEnd: function(){
                            map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
                            map.enableScrollZoom();
                            geocoder = new YMaps.Geocoder(response.mapsLocation);
                            ShowNewLoc();
                        }
                    });
                }
            }
        });
    },
    OpenEdit:function (elem) {
        $.ajax({
            url: this.editFormUrl,
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