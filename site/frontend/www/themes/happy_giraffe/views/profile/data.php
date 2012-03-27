<?php Yii::app()->clientScript
    ->registerScriptFile('/javascripts/location.js')
    ->registerScript('profile-location', '
        UserLocation.regionUrl = "' . Yii::app()->createUrl('geo/geo/regions') . '";
        UserLocation.cityUrl = "' . Yii::app()->createUrl('geo/geo/cities') . '";
        UserLocation.saveUrl = "' . Yii::app()->createUrl('geo/geo/saveLocation') . '";
        UserLocation.regionIsCityUrl = "' . Yii::app()->createUrl('geo/geo/regionIsCity') . '";
    ')
    ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);
$regions = array('' => '');

if ($this->user->getUserAddress()->country_id !== null) {
    $regions = array('' => '') + CHtml::listData(GeoRegion::model()->findAll(array(
        'order' => 'id', 'select' => 'id,name', 'condition' => 'country_id = ' . $this->user->userAddress->country_id)), 'id', 'name');
}
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form'
));
?>
<div class="profile-form-in">

    <?php echo $form->errorSummary($this->user); ?>

    <div class="row row-inline clearfix">

        <div class="row-title">Персональные данные:</div>
        <div class="row-elements">
            <div class="col">
                <?php echo $form->textField($this->user, 'last_name', array(
                'placeholder' => 'Фамилия',
            )); ?>
            </div>
            <div class="col">
                <?php echo $form->textField($this->user, 'first_name', array(
                'placeholder' => 'Имя',
            )); ?>
            </div>

        </div>

    </div>

    <div class="row row-inline clearfix">

        <div class="row-title">Дата рождения:</div>
        <div class="row-elements">
            <div class="col">
                <div class="select-box">
                    <?php
                    $this->widget('DateWidget', array(
                        'model' => $this->user,
                        'attribute' => 'birthday',
                    ));
                    ?>
                </div>
            </div>
            <?php if ($this->user->birthday): ?>
            <div class="col age">
                Возраст: <b><?php echo $this->user->age; ?></b> <?php echo $this->user->ageSuffix; ?>
            </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="row row-inline clearfix">

        <div class="row-title">Пол:</div>
        <div class="row-elements">
            <div class="col">
                <label><?php echo $form->radioButton($this->user, 'gender', array('value' => 0)); ?> Женщина</label>

            </div>
            <div class="col">
                <label><?php echo $form->radioButton($this->user, 'gender', array('value' => 1)); ?> Мужчина</label>
            </div>

        </div>

    </div>

    <div class="row row-inline clearfix">

        <div class="row-title">Место жительства:</div>
        <div class="row-elements">
            <div class="col">
                <div class="select-box">
                    <?php echo CHtml::dropDownList('country_id', $this->user->getUserAddress()->country_id,
                    array('' => '') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
                    array(
                        'class' => 'chzn w-200',
                        'data-placeholder' => 'Выберите страну',
                        'onchange' => 'UserLocation.SelectCounty($(this));'
                    )) ?>
                    <div class="col">
                        <?php echo CHtml::dropDownList('region_id', $this->user->getUserAddress()->region_id, $regions,
                        array(
                            'class' => 'chzn w-200',
                            'data-placeholder' => 'Выберите регион',
                            'onchange' => 'UserLocation.RegionChanged($(this));'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-inline clearfix settlement" <?php
        if ($this->user->getUserAddress()->region !== null
            && $this->user->getUserAddress()->region->isCity()
        ) echo ' style="display:none;"' ?>>

        <div class="row-title">Населенный пункт:</div>
        <div class="row-elements">
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'city_name',
                'name' => 'city_name',
                'value' => ($this->user->getUserAddress()->city === null) ? '' : $this->user->getUserAddress()->city->name,
                'source' => "js: function(request, response){
                            $.ajax({
                                url: '" . $this->createUrl('/geo/geo/cities') . "',
                                dataType: 'json',
                                data: {
                                    term: request.term,
                                    country_id: $('#country_id').val(),
                                    region_id: $('#region_id').val()
                                },
                                success: function (data)
                                {
                                    response(data);
                                }
                            })
                        }",
                'options' => array(
                    'select' => "js:function (event, ui)
                                {
                                    $('#city_id').val(ui.item.id);
                                    geocoder = new YMaps.Geocoder($('#country_id option:selected').text()
                                        + ', ' + $('#region_id option:selected').text()
                                        + ', ' + ui.item.label);
                                    ShowNewLoc();
                                }
                            ",
                    'htmlOptions' => array(
                        'placeholder' => 'Выберите город'
                    )
                ),
            ));
            ?>
            <?php echo CHtml::hiddenField('city_id', $this->user->userAddress->city_id); ?>&nbsp;&nbsp;
            <div class="text-inline"> Введите свой город, поселок, село<br>или деревню</div>
        </div>
    </div>
</div>

<div id="YMapsID" style="width:600px;height:400px;margin-bottom: 20px;"></div>

<div class="row row-inline clearfix">

    <div class="row-title">E-mail:</div>
    <div class="row-elements">
        <div class="col">
            <?php echo $form->textField($this->user, 'email', array('placeholder' => 'Ваш e-mail')); ?>
            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
        </div>
    </div>

</div>

<div class="row row-inline clearfix">

    <div class="row-title">Участник с:</div>
    <div class="row-elements">
        <div class="text small">
            <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->user->register_date); ?>
        </div>
    </div>

</div>

<div class="row row-inline clearfix">
    <div class="row-title">Удалить анкету:</div>
    <div class="row-elements">
        <div class="text">Да, я
            хочу <?php echo CHtml::link('Удалить анкету', array('remove'), array('class' => 'remove', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?>
            , потеряв всю введенную информацию без возможности восстановления.
        </div>
    </div>
</div>

<div class="bottom">
    <button class="btn btn-green-medium btn-arrow-right">
        <span><span>Сохранить<img src="/images/arrow_r.png"/></span></span>
    </button>
</div>
<script type="text/javascript">
    var directionsDisplay;
    var geocoder;
    var map;
    var placemark;
    var s;

    $(function () {
        BalloonStyle();

        // Создание экземпляра карты и его привязка к созданному контейнеру
        map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
        // Добавление элементов управления
        map.addControl(new YMaps.TypeControl());
        map.addControl(new YMaps.ToolBar());
        map.addControl(new YMaps.Zoom());
        map.addControl(new YMaps.MiniMap());
        map.addControl(new YMaps.ScaleLine());
        //map.addControl(new YMaps.SearchControl());

        // Создание объекта геокодера
        var user_loc = "<?php echo $this->user->userAddress->getLocationString() ?>";
        geocoder = new YMaps.Geocoder(user_loc);
        ShowNewLoc();

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });

        $("#country_id").chosen({allow_single_deselect:true}).change(function () {
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text());
            ShowNewLoc();
        });

        $('#region_id').chosen({allow_single_deselect:true}).change(function () {
            //console.log($("#region_id option:selected").text());
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text() + ", " + $("#region_id option:selected").text());
            ShowNewLoc();
        });
    });

    function ShowNewLoc() {
        console.log('1');
        YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
            if (geocoder.length()) {
                map.setBounds(geocoder.get(0).getBounds());
                //console.log(geocoder.get(0));
                map.removeOverlay(placemark);
                placemark = new YMaps.Placemark(geocoder.get(0).getCoordPoint(), {style:s});
                placemark.name = geocoder.request;
                map.addOverlay(placemark);
            }
        });
    }

    function BalloonStyle() {
        // Создает стиль
        s = new YMaps.Style();
        // Создает стиль значка метки
        s.iconStyle = new YMaps.IconStyle();

        //стиль метки
        s.iconStyle.href = "/images/map_marker.png";
        s.iconStyle.size = new YMaps.Point(34, 46);
        s.iconStyle.offset = new YMaps.Point(-17, -46);
    }
</script>
<?php $this->endWidget(); ?>