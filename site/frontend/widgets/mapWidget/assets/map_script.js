/**
 * Author: alexk984
 * Date: 17.05.12
 */
var HMap = {
    address:null,
    coordinates:null,
    map_id:null,
    style:null,
    map:null,
    initGoogleMap:function () {
        var geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById(this.map_id), {
            center:new google.maps.LatLng(0, 0),
            zoom:8,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        });
        this.map = map;
        var address = this.address;

        geocoder.geocode({"address":address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            } else {
                console.log("Geocode was not successful for the following reason: " + status);
            }
        });
    },
    initYandexMap:function () {
        // Создает стиль
        HMap.s = new YMaps.Style();
        // Создает стиль значка метки
        HMap.s.iconStyle = new YMaps.IconStyle();

        //стиль метки
        HMap.s.iconStyle.href = "/images/map_marker.png";
        HMap.s.iconStyle.size = new YMaps.Point(31, 35);
        HMap.s.iconStyle.offset = new YMaps.Point(-10, -35);



        var placemark;
        var map = new YMaps.Map(document.getElementById(this.map_id));
        this.map = map;
        map.enableScrollZoom();

        // Создание объекта геокодера
        var user_loc = this.address;
        var geocoder = new YMaps.Geocoder(user_loc);
        YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
            if (geocoder.length()) {
                map.setBounds(geocoder.get(0).getBounds());
                map.removeOverlay(placemark);
                placemark = new YMaps.Placemark(map.getCenter(), {style:HMap.s});
                map.addOverlay(placemark);
            }
        });

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });
    }
}