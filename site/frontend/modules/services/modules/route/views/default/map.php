<?php
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=' . Yii::app()->params['google_map_key'] . '&sensor=true');

$start = 'Россия, Волгоград';
$end = 'Россия, Москва';
?>
<div id="map_canvas" style="width:600px; height:600px"></div>
<script type="text/javascript">
    var map;

    $(function () {
        var directionsService = new google.maps.DirectionsService();

        var directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
            zoom:7,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        directionsDisplay.setMap(map);

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

                console.log(response);


                var rlegs = [];
                for (i = 0; i < response.routes[0].legs.length; i++) {
                    rlegs[i] = {
                        distance:response.routes[0].legs[i].distance.value,
                        duration:response.routes[0].legs[i].duration.value,
                        t1_lat:response.routes[0].legs[i].start_location.lat(),
                        t1_lng:response.routes[0].legs[i].start_location.lng(),
                        t2_lat:response.routes[0].legs[i].end_location.lat(),
                        t2_lng:response.routes[0].legs[i].end_location.lng(),
                        t1_addr:response.routes[0].legs[i].start_address,
                        t2_addr:response.routes[0].legs[i].end_address
                    }
                }

                showStepsInc(response);

            }
        });
    });

    function showStepsInc(directionResult) {
        var icon_pt = new google.maps.MarkerImage('/images/map_marker2.png', new google.maps.Size(8, 7), new google.maps.Point(0, 0), new google.maps.Point(3, 3));
        for (var l = 0; l < directionResult.routes[0].legs.length; l++) {
            var myRoute = directionResult.routes[0].legs[l];
            for (var i = 0; i < myRoute.steps.length; i++) {
                var marker = new google.maps.Marker({
                    position:myRoute.steps[i].start_point,
                    icon:icon_pt,
                    map:map
                });
                attachInstructionText(marker, myRoute.steps[i].instructions);
                console.log(marker);
            }
        }
    }

    function attachInstructionText(marker, text) {
        google.maps.event.addListener(marker, 'click', function() {
            stepDisplay.setContent(text);
            stepDisplay.open(map, marker);
        });
    }

    function WorkFlowPoints(result){
        var rlegs=[];
        for(r=0;r<result.routes.length;r++){
            for(i=0;i<result.routes[r].legs.length;i++){
                var route_arr=result.routes[r].legs[i];
                var stps=[];
                for (var j=0;j<route_arr.steps.length;j++) {
                    stps[j]={
                        lat:result.routes[r].legs[i].steps[j].end_point.lat(),
                        lng:result.routes[r].legs[i].steps[j].end_point.lng(),
                        distance:result.routes[r].legs[i].steps[j].distance.value,
                        duration:result.routes[r].legs[i].steps[j].duration.value,
                    }
                }

                rlegs[i]={
                    t1_lat:result.routes[r].legs[i].start_location.lat(),
                    t1_lng:result.routes[r].legs[i].start_location.lng(),
                    t2_lat:result.routes[r].legs[i].end_location.lat(),
                    t2_lng:result.routes[r].legs[i].end_location.lng(),
                    stps:stps
                }
            }
        }
        $.post('/ajax/getPoints',{rlegs:rlegs,route_id:$('#route_id').val(),route_inc_id:$('#route_inc_id').val()},function(data){
            $('#route_points_id').html(data);
        });
    }

</script>