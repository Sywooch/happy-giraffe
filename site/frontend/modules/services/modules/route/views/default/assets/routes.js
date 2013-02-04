/**
 * Author: alexk984
 * Date: 01.02.13
 */

var Routes = {
    map:null,
    init:function(start, end){
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
            zoom:7,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        directionsDisplay.setMap(map);

        var request = {
            origin:start,
            destination:end,
            travelMode:google.maps.DirectionsTravelMode.DRIVING,
            provideRouteAlternatives:true
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
}