<?php
/**
 * @var $post CommunityContent
 */
?>
<h2>Месторасположение</h2>
<br>
<form action="" id="location-form" class="form">
    <input type="hidden" id="model_id" name="id" value="<?=$post->id ?>">
    <?php echo CHtml::textField('location', $post->morningPost->location, array('class' => 'w-500')); ?>
    <br>
    <a href="" onclick="showOnMap();return false;">Показать на карте</a>

    <div id="map_canvas" style="width:223px; height:200px"></div>
    <input type="hidden" id="lat" name="lat" value="<?=$post->morningPost->lat ?>">
    <input type="hidden" id="long" name="long" value="<?=$post->morningPost->long ?>">
    <input type="hidden" id="zoom" name="zoom" value="<?=empty($post->morningPost->zoom)?'5':$post->morningPost->zoom ?>">

    <div class="row row-buttons">
        <button class="btn btn-green-medium">
            <span><span>Сохранить</span></span></button>
    </div>
</form>

<script type="text/javascript">
    var map;
    var geocoder;
    var model_id = <?= $post->id ?>;

    $(function () {
        geocoder = new google.maps.Geocoder();

        <?php if (!empty($post->morningPost->lat) && !empty($post->morningPost->long) && !empty($post->morningPost->zoom)) {?>

            var myOptions = {
                center:new google.maps.LatLng(<?= $post->morningPost->lat ?>, <?= $post->morningPost->long ?>),
                mapTypeId:google.maps.MapTypeId.ROADMAP,
                zoom:<?= $post->morningPost->zoom ?>
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        <?php } else {?>
            var myOptions = {
                mapTypeId:google.maps.MapTypeId.ROADMAP,
                zoom:5
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        <?php } ?>

        $('#location').keypress(function (event) {
            if (event.which == 13) {
                showOnMap();
                return false;
            }
        });

        google.maps.event.addListener(map, 'center_changed', function () {
            var location = map.getCenter();
            $("#lat").val(location.lat());
            $("#long").val(location.lng());
        });
        google.maps.event.addListener(map, 'zoom_changed', function () {
            var zoomLevel = map.getZoom();
            $("#zoom").val(zoomLevel);
        });

        $('button').click(function () {
            $.post('/morning/saveLocation/', $('#location-form').serialize(), function (response) {
                if (response.status) {
                    $('.location').html(response.html);
                    delete(map);
                    $.fancybox.close();
                }
            }, 'json');

            return false;
        });
    });

    function showOnMap() {
        var address = document.getElementById("location").value;
        geocoder.geocode({ 'address':address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map:map,
                    position:results[0].geometry.location
                });
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
</script>