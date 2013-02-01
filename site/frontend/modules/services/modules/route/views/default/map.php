<?php
Yii::app()->clientScript
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=' . Yii::app()->params['google_map_key'] . '&sensor=true')
    ->registerCoreScript('jquery.ui');

$start = 'Россия, Волгоград';
$end = 'Россия, Москва';
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?libraries=places&sensor=true');
?>
<style type="text/css">
    .pac-container:after {content: none !important;}
</style>
<div>
    <input id="searchTextField" type="text" size="50">
</div>
<div id="map_canvas" style="width:600px; height:600px"></div>
<script type="text/javascript">
    var map;
    var infowindow;
    var PlacesService;

    $(function () {
        var directionsService = new google.maps.DirectionsService();

        var directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
            zoom:7,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        directionsDisplay.setMap(map);

        PlacesService = new google.maps.places.PlacesService(map);

        initializeAutoComplete();

        var start = '<?=$start ?>';
        var end = '<?=$end ?>';
        var request = {
            origin:start,
            destination:end,
            travelMode:google.maps.DirectionsTravelMode.DRIVING,
            provideRouteAlternatives:true
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);

                var rlegs = [];
                var steps = response.routes[0].legs[0].steps;
                for (var i = 0; i < steps.length; i++) {
                    rlegs[i] = {
                        distance:steps[i].distance.value,
                        duration:steps[i].duration.value,
                        t1_lat:steps[i].end_location.Ya,
                        t1_lng:steps[i].end_location.Za,
                        t2_lat:steps[i].end_location.Ya,
                        t2_lng:steps[i].end_location.Za
                    }

                }

//                console.log(rlegs);
//                $.ajax({
//                    url:'/routes/getRoutes/',
//                    data:{data:rlegs},
//                    type:'POST',
//                    success:function (response) {
//                        $('#result').html(response);
//                    }
//                });
            }
        });

//        $('#searchTextField').autocomplete({
//            minLength:3,
//            source:function (request, response) {
//                console.log(request.term);
//
//                var defaultBounds = new google.maps.LatLngBounds(
//                        new google.maps.LatLng(81.85812210, -169.04651970),
//                        new google.maps.LatLng(41.1853530, 19.64053270)
//                );
//                var moscow = new google.maps.LatLng(55.7496460, 37.623680);
//                PlacesService.textSearch({query:request.term}, FoundPlaceCallback);
//            },
//            select:function (event, ui) {
//                $(this).next('input').val(ui.item.id);
//            }
//        });


    });

    function FoundPlaceCallback(place, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {

        }

        console.log(place);
        console.log(status);
    }

    function initializeAutoComplete() {

        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input, {types:['(cities)']});

        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(autocomplete, 'place_changed', function() {

            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                console.log('not found');
                return;
            }

            console.log(place);
        });
    }


</script>

<div id="result"></div>