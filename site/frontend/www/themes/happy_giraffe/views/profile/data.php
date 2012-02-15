<?php Yii::app()->clientScript
    ->registerScriptFile('/javascripts/chosen.jquery.min.js')
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?sensor=false&language=ru&region=ru')
    ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);
$user = User::getUserById(Yii::app()->user->getId());
$region_id = empty($user->settlement_id) ? null : $user->settlement->region_id;
$district_id = empty($user->settlement_id) ? null : $user->settlement->district_id;
$districts = empty($region_id) ? array() : CHtml::listData(
    GeoRusDistrict::model()->findAll('region_id = ' . $region_id), 'id', 'name');
$city_id = empty($user->settlement_id) ? null : $user->settlement_id;
$city_name = empty($user->settlement_id) ? null : $user->settlement->name;

$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    '<b>Личная информация</b>',
); ?>
<style type="text/css">
    #map_canvas {
        height: 400px;
        width: 600px;
    }
</style>
<?php $form = $this->beginWidget('CActiveForm'); ?>
<div class="profile-form-in">

<?php echo $form->errorSummary($this->user); ?>

<div class="row row-inline">

    <div class="row-title">Персональные данные:</div>
    <div class="row-elements">
        <div class="col">
            <?php echo $form->textField($this->user, 'last_name', array(
            'placeholder' => 'Фамилия',
            'class' => (empty($this->user->last_name)) ? "placeholder" : '',
            'onfocus' => "unsetPlaceholder(this);",
            'onblur' => "setPlaceholder(this);"
        )); ?>
        </div>
        <div class="col">
            <?php echo $form->textField($this->user, 'first_name', array(
            'placeholder' => 'Имя',
            'class' => (empty($this->user->first_name)) ? "placeholder" : '',
            'onfocus' => "unsetPlaceholder(this);",
            'onblur' => "setPlaceholder(this);"
        )); ?>
        </div>

    </div>

</div>

<div class="row row-inline">

    <div class="row-title">Дата рождения:</div>
    <div class="row-elements">
        <div class="col">
            <?php
            $this->widget('DateWidget', array(
                'model' => $this->user,
                'attribute' => 'birthday',
            ));
            ?>
        </div>
        <div class="col age">
            Возраст: <b><?php echo $this->user->age; ?></b> лет
        </div>

    </div>

</div>

<div class="row row-inline">

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

<div class="row row-inline">

    <div class="row-title">Место жительства:</div>
    <div class="row-elements">
        <div class="col">
            <ul>
                <li class="with-search">
                    <?php echo CHtml::dropDownList('country_id', $user->country_id,
                    array('' => '') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
                    array(
                        'class' => 'chzn chzn-deselect',
                        'data-placeholder' => 'Выберите страну',
                    )); ?>
                </li>
                <li class="with-search">
                    <?php echo CHtml::dropDownList('region_id', $region_id,
                    array('' => '') + CHtml::listData(GeoRusRegion::model()->findAll(array('order' => 'pos,id', 'select' => 'id,name')), 'id', 'name'),
                    array(
                        'class' => 'chzn chzn-deselect',
                        'data-placeholder' => 'Выберите регион',
                    )); ?>
                </li>
                <li class="with-search">
                    <?php echo CHtml::dropDownList('district_id', $district_id, $districts, array(
                    'empty' => '',
                    'class' => 'chzn chzn-deselect',
                    'data-placeholder' => 'Выберите район',
                    'style' => 'width: 300px;'
                )); ?>
                </li>
                <li>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id' => 'city_name',
                        'name' => 'city_name',
                        'value' => $city_name,
                        'source' => "js: function(request, response)
					{
						$.ajax({
							url: '" . $this->createUrl('/geo/geo/cities') . "',
							dataType: 'json',
							data: {
								term: request.term,
								country_id: $('#country_id').val(),
								region_id: $('#region_id').val(),
								district_id: $('#district_id').val()
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

                            ShowStreet();
                            console.log(ui.item.value);
                            geocoder = new YMaps.Geocoder($('#country_id option:selected').text()
                                + ', ' + $('#region_id option:selected').text()
                                + ', ' + ui.item.value);
                            ShowNewLoc();
						}
					",

                        ),
                        'htmlOptions' => array(
                            'style' => (empty($region_id)) ? 'display: none;' : '',
                            'placeholder' => 'Выберите город',
                            'class' => (empty($region_id)) ? "placeholder" : '',
                            'onfocus' => "unsetPlaceholder(this);",
                            'onblur' => "setPlaceholder(this);"
                        )
                    ));
                    ?>
                    <?php echo CHtml::hiddenField('city_id', $city_id); ?>
                </li>
                <li>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id' => 'street_name',
                        'name' => 'street_name',
                        'value' => empty($user->street) ? '' : $user->street->name,
                        'source' => "js: function(request, response)
					{
						$.ajax({
							url: '" . $this->createUrl('/geo/geo/street') . "',
							dataType: 'json',
							data: {
								term: request.term,
								city_id: $('#city_id').val(),
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
                            $('#street_id').val(ui.item.id);
                            console.log(ui.item.value);
                            geocoder = new YMaps.Geocoder($('#country_id option:selected').text()
                                + ', ' + $('#region_id option:selected').text()
                                + ', ' + $('#district_id option:selected').text()
                                + ', ' + ui.item.value);
                            ShowNewLoc();
						}
					",

                        ),
                        'htmlOptions' => array(
                            'style' => (empty($region_id)) ? 'display: none;' : '',
                            'placeholder' => 'Выберите улицу',
                            'class' => (empty($city_id)) ? "placeholder" : '',
                            'onfocus' => "unsetPlaceholder(this);",
                            'onblur' => "setPlaceholder(this);"
                        )
                    ));
                    ?>
                    <?php echo CHtml::hiddenField('street_id', $user->street_id);?>
                </li>
                <li>
                    <?php echo CHtml::textField('house', $user->house, array(
                    'placeholder' => 'дом',
                    'class' => (empty($user->house)) ? "placeholder" : '',
                    'onfocus' => "unsetPlaceholder(this);",
                    'onblur' => "setPlaceholder(this);"
                )) ?>
                </li>
                <li>
                    <?php echo CHtml::textField('room', $user->room, array(
                    'placeholder' => 'квартира',
                    'class' => (empty($user->room)) ? "placeholder" : '',
                    'onfocus' => "unsetPlaceholder(this);",
                    'onblur' => "setPlaceholder(this);"
                )) ?>
                </li>
            </ul>
        </div>


    </div>

</div>
<div>
    <div class="inner" id="map_container" style="display: none;"
         data-name="<?php echo $user->getLocationString() ?>"
         data-zoom="<?php echo $user->getZoom() ?>">
        <div class="clearfix">

            <div id="map_canvas"></div>
        </div>
    </div>
    <div id="YMapsID" style="width:600px;height:400px;margin-bottom: 20px;"></div>
</div>

<div class="row row-inline">

    <div class="row-title">E-mail:</div>
    <div class="row-elements">
        <div class="col">
            <?php echo $form->textField($this->user, 'email'); ?>
        </div>
    </div>

</div>

<div class="row row-inline">
    <div class="row-title">Удалить анкету:</div>
    <div class="row-elements">
        <div class="text">Да, я
            хочу <?php echo CHtml::link('Удалить анкету', array('remove'), array('class' => 'remove', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?>
            , потеряв всю введенную информацию без возможности восстановления.
        </div>
    </div>
</div>

</div>
</div>
<div class="bottom">
    <button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img
        src="/images/arrow_r.png"/></span></span></button>
</div>
<script type="text/javascript">
    var directionsDisplay;
    var geocoder;
    var map;
    var placemark;

    $(function () {
        /*
                geocoder = new google.maps.Geocoder();

                console.log($('#map_container').attr("data-name"));
                geocoder.geocode({ 'address':$('#map_container').attr("data-name"), 'latLng':PlaceLoc}, function (results, status) {
                    if ((status == google.maps.GeocoderStatus.OK)) {
                        var loc = results[0].geometry.location;
                        console.log(loc);
                        PlaceLoc = new google.maps.LatLng(loc.lat(), loc.lng());

                        var myOptions = {
                            center:PlaceLoc,
                            zoom:(parseInt($('#map_container').attr("data-zoom"))),
                            MapTypeId:google.maps.MapTypeId.ROADMAP
                        };
                        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                        directionsDisplay = new google.maps.DirectionsRenderer();
                        directionsDisplay.setMap(map);
                    } else {
                        console.log("bad answer from maps");
                    }
                });
        */

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
        var user_loc = "<?php echo $user->getLocationString() ?>";
        geocoder = new YMaps.Geocoder(user_loc);
        ShowNewLoc();

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });

        $("#country_id").chosen({allow_single_deselect:true}).change(function () {
            console.log($("#country_id option:selected").text());
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text());
            ShowNewLoc();

            if ($(this).val() == 174) {
                $('#region_id_chzn').show();
                if ($('#region_id').val() != '' && $('#region_id').val() != 42 && $('#region_id').val() != 59) {
                    $('#district_id_chzn').show();
                    $('#city_name').show();
                }
            } else {
                $('#region_id_chzn').hide();
                $('#district_id_chzn').hide();
                $('#city_name').hide();

                HideStreet();
            }
        });

        $('#region_id').chosen({allow_single_deselect:true}).change(function () {
            console.log($("#region_id option:selected").text());
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text() + ", " + $("#region_id option:selected").text());
            ShowNewLoc();

            if ($(this).val() == '' || $(this).val() == 42 || $(this).val() == 59) {
                $('#district_id_chzn').hide();
                $('#city_name').hide();
                if ($(this).val() == '') {
                    $('#street_name').hide();
                    $('#house').hide();
                    $('#room').hide();
                } else {
                    if ($(this).val() == 42)
                        $('#city_id').val(148315);
                    if ($(this).val() == 59)
                        $('#city_id').val(148316);
                    ShowStreet();
                }
            } else {
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("/geo/geo/districts") ?>',
                    data:{
                        country_id:$('#country_id').val(),
                        region_id:$(this).val()
                    },
                    type:'POST',
                    success:function (response) {
                        $('#district_id_chzn').show();
                        $('#city_name').show();

                        $('#district_id').html(response);
                        $("#district_id").trigger("liszt:updated");
                        $('#city_id').val('');
                        $('#city_name').val('');

                        HideStreet();

                    },
                    context:$(this)
                });
            }
        });

        $('#district_id').chosen({allow_single_deselect:true}).change(function () {
            $('#city_id').val('');
            $('#city_name').val('');

            console.log($("#district_id option:selected").text());
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text()
                + ", " + $("#region_id option:selected").text() + ", " + $("#district_id option:selected").text());
            ShowNewLoc();

            HideStreet();
        });

        if ($('#country_id').val() != 174) {
            $('#region_id_chzn').hide();
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            HideStreet();
        }

        if ($('#region_id').val() == 42 || $('#region_id').val() == 59) {
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            $('#street_name').show();
            $('#house').show();
            $('#room').show();
        } else if ($('#region_id').val() == '') {
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            HideStreet();
        }
    });

    function ShowStreet() {
        $('#street_name').show();
        $('#house').show();
        $('#room').show();

        $('#street_name').val('');
        setPlaceholder(document.getElementById('street_name'));
        $('#street_id').val('');
        setPlaceholder(document.getElementById('street_id'));
        $('#house').val('');
        setPlaceholder(document.getElementById('house'));
        $('#room').val('');
        setPlaceholder(document.getElementById('room'));
    }
    function HideStreet() {
        $('#street_name').hide();
        $('#house').hide();
        $('#room').hide();
    }

    $('#house').change(function(){
        geocoder = new YMaps.Geocoder($('#country_id option:selected').text()
            + ', ' + $('#region_id option:selected').text()
            + ', ' + $('#district_id option:selected').text()
            + ', ' + $('#street_name').val()
            + ', ' + $('#house').val());
        ShowNewLoc();
    });

    function ShowNewLoc() {
        YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
            if (geocoder.length()) {
                map.setBounds(geocoder.get(0).getBounds());
                map.removeOverlay(placemark);
                placemark = new YMaps.Placemark(map.getCenter());
                map.addOverlay(placemark);
            }
        });
    }
</script>
<?php $this->endWidget(); ?>