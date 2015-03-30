<?php
/**
 * @var LiteController $this
 */
$this->pageTitle = 'Контакты';
?>

<div class="info-hero info-start">
    <div class="info-hero-line main">По всем вопросам и предложениям по работе сайта обращайтесь</div>
    <div class="info-hero-line"><a href="mailto:info@happy-giraffe.ru" class="info-hero-line__mail blue">info@happy-giraffe.ru</a></div>
    <div class="info-hero-line main">
        <div class="info-hero-line__part">
            <div class="info-hero-line__part__question">
                У вас важный <br />
                вопрос?
            </div>
        </div>
        <div class="info-hero-line__part"><img src="/lite/images/info/ceo.png" alt=""></div>
        <div class="info-hero-line__part text-left">
            <div class="info-hero-line__part__small position">Генеральный директор</div>
            <div class="info-hero-line__part__small name">Мира Смурков</div>
            <div class="info-hero-line__part__small"><a href="mailto:mira@happy-giraffe.ru" class="info-hero-line__part__mail">mira@happy-giraffe.ru</a></div>
        </div>
    </div>
</div>
<div class="info-maps">
    <div class="info-maps-part left">
        <div class="info-maps-address">
            <span class="bold">Главный офис </span>
            г. Москва, Пресненская набережная, д.12
        </div>
        <div id="maps-main" class="info-maps-map"></div>
    </div>
    <div class="info-maps-part right">
        <div class="info-maps-address">
            <span class="bold">Офис разработки </span>
            г. Ярославль, пр-т. Толбухина, 8/75
        </div>
        <div id="maps-develop" class="info-maps-map"></div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->widget('site\frontend\modules\pages\widgets\contactFormWidget\ContactFormWidget'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCJ1S2cRAzz8_QA0yKA6WVqDT6eZ476Sow"></script>
<script type="text/javascript">
    var initialize = function initialize(mapId, coordx, coordy) {
        var mapOptions,
            marker,
            map,
            markerImage = '/lite/images/info/marker.png',
            position = new google.maps.LatLng(coordx, coordy);
        mapOptions = {
            center: position,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false
        };
        map = new google.maps.Map(document.getElementById(mapId), mapOptions);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: markerImage
        });
    }

    initialize("maps-main", 55.750086, 37.537263);
    initialize("maps-develop", 57.620702, 39.858704);
</script>
