<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 * @param $user User
 */

$js = 'var geocoder;
    var map;
    var placemark;
    var s;

    $(function () {
        BalloonStyle();

        map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
        map.enableScrollZoom();

        // Создание объекта геокодера
        var user_loc = "' . $this->user->getUserAddress()->getLocationString() . '";
        geocoder = new YMaps.Geocoder(user_loc);
        ShowNewLoc();

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });
     });

    function ShowNewLoc() {
        YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
            if (geocoder.length()) {
                map.setBounds(geocoder.get(0).getBounds());
                map.removeOverlay(placemark);
                placemark = new YMaps.Placemark(map.getCenter(), {style: s});
                //placemark.name = "' . $this->user->getUserAddress()->getLocationString() . '";
                map.addOverlay(placemark);
            }
        });
    }

    function BalloonStyle(){
        // Создает стиль
        s = new YMaps.Style();
        // Создает стиль значка метки
        s.iconStyle = new YMaps.IconStyle();

        //стиль метки
        s.iconStyle.href = "/images/map_marker.png";
        s.iconStyle.size = new YMaps.Point(31, 35);
        s.iconStyle.offset = new YMaps.Point(-10, -35);
    }

    UserLocation.regionUrl = "'.Yii::app()->createUrl('geo/geo/regions').'";
    UserLocation.cityUrl = "'.Yii::app()->createUrl('geo/geo/cities').'";
    UserLocation.saveUrl = "'.Yii::app()->createUrl('geo/geo/saveLocation').'";
    UserLocation.regionIsCityUrl = "'.Yii::app()->createUrl('geo/geo/regionIsCity').'";
    UserLocation.editFormUrl = "'.Yii::app()->createUrl('/geo/geo/locationForm').'";
    ';

Yii::app()->clientScript
    ->registerScriptFile('/javascripts/location.js')
    ->registerScript('LocaionWidget', $js, CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/jquery.flip.js')
    ->registerCoreScript('jquery.ui')
    ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);

if ($this->isMyProfile && empty($user->getUserAddress()->country_id)):?>
<div class="user-map user-add">
    <a href="#" onclick="UserLocation.OpenEdit();return false;"><big>Я живу<br>здесь</big><img src="/images/user_map_cap.png"></a>
    <div id="YMapsID" style="width:322px;height:199px;display:none;"></div>
</div>
<?php else: ?>
<div class="user-map">
    <div class="header">
        <?php if ($this->isMyProfile):?>
            <a href="<?=Yii::app()->createUrl('/geo/geo/locationForm') ?>" class="edit" onclick="UserLocation.OpenEdit();return false;"><span class="tip">Изменить</span></a>
        <?php endif ?>
        <div class="box-title">Я здесь</div>
        <div class="sep"><img src="/images/map_marker.png"></div>
        <div class="location">
            <?php echo $this->user->getUserAddress()->getFlag() ?> <?= $user->getUserAddress()->country->name ?>
            <p><?= $user->getUserAddress()->getLocationWithoutCountry() ?></p>
        </div>
    </div>

    <div id="YMapsID" style="width:322px;height:199px;"></div>
</div>
<?php endif; ?>