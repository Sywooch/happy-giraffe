/**
 * Author: alexk984
 * Date: 17.05.12
 */

function HYandexMap() {
    this.s = null;
    this.map = null;
    this.placemark = null;
}
HYandexMap.prototype.create = function (map_id, address) {
    // Создает стиль
    this.s = new YMaps.Style();
    // Создает стиль значка метки
    this.s.iconStyle = new YMaps.IconStyle();

    //стиль метки
    this.s.iconStyle.href = "/images/map_marker-2.png";
    //this.s.iconStyle.size = new YMaps.Point(31, 35);
    this.s.iconStyle.offset = new YMaps.Point(-10, -35);

    this.map = new YMaps.Map(document.getElementById(map_id));
    this.map.enableScrollZoom();
    var $this = this;

    // Создание объекта геокодера
    var geocoder = new YMaps.Geocoder(address);
    YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
        if (geocoder.length()) {
            $this.map.setBounds(geocoder.get(0).getBounds());
            $this.map.removeOverlay($this.placemark);
            $this.placemark = new YMaps.Placemark(geocoder.get(0).getGeoPoint(), {style:$this.s});
            $this.map.addOverlay($this.placemark);
        }
    });

    YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
        console.log("Произошла ошибка: " + errorMessage)
    });
};
HYandexMap.prototype.delete = function () {
};


function HGoogleMap() {
    this.map = null;
    this.placemark = null;
}
HGoogleMap.prototype.create = function (map_id, address) {
    var geocoder = new google.maps.Geocoder();
    this.map = new google.maps.Map(document.getElementById(map_id), {
        center:new google.maps.LatLng(0, 0),
        zoom:8,
        mapTypeId:google.maps.MapTypeId.ROADMAP,
        mapTypeControl:false,
        streetViewControl:false
    });
    var $this = this;

    geocoder.geocode({"address":address}, function (results, status) {
        console.log(address);
        if (status == google.maps.GeocoderStatus.OK) {
            $this.map.setCenter(results[0].geometry.location);

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: $this.map,
                icon: '/images/map_marker-2.png'
            });

        } else {
            console.log("Geocode was not successful for the following reason: " + status);
        }
    });
};

HGoogleMap.prototype.delete = function () {
};