<?php Yii::app()->clientScript
    ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);
$user = User::getUserById(Yii::app()->user->id);
$region_id = empty($user->settlement_id) ? null : $user->settlement->region_id;
//$district_id = empty($user->settlement_id) ? null : $user->settlement->district_id;
//$districts = empty($region_id) ? array() : CHtml::listData(
//GeoRusDistrict::model()->findAll('region_id = ' . $region_id), 'id', 'name');
$city_id = empty($user->settlement_id) ? null : $user->settlement_id;
$city_name = empty($user->settlement_id) ? null : $user->settlement->name;

$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    '<b>Личная информация</b>',
); ?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form'
)); ?>
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
                    <?php echo CHtml::dropDownList('country_id', $user->country_id,
                    array('' => '') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
                    array(
                        'class' => 'chzn',
                        'data-placeholder' => 'Выберите страну',
                        'style' => 'width:170px'
                    )).'&nbsp;&nbsp;'; ?>
                    <div class="col" <?php if ($user->country_id != 174) echo 'style="display:none;"' ?>>
                        <?php echo CHtml::dropDownList('region_id', $region_id,
                        array('' => '') + CHtml::listData(GeoRusRegion::model()->findAll(array('order' => 'pos,id', 'select' => 'id,name')), 'id', 'name'),
                        array(
                            'class' => 'chzn',
                            'data-placeholder' => 'Выберите регион',
                            'style' => 'width:230px'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="row row-inline clearfix" <?php if (empty($region_id) || $region_id == 42 || $region_id == 59) echo 'style="display: none;"' ?>>

        <div class="row-title">Населенный пункт:</div>
        <div class="row-elements">
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
                                + ', ' + ui.item.value);
                            ShowNewLoc();
						}
					",

                ),
                'htmlOptions' => array(
//                    'placeholder' => 'город',
                )
            ));
            ?>
            <?php echo CHtml::hiddenField('city_id', $city_id); ?>&nbsp;&nbsp;
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
            <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $user->register_date); ?>
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
    <button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img
        src="/images/arrow_r.png"/></span></span></button>
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
        var user_loc = "<?php echo $user->getLocationString() ?>";
        geocoder = new YMaps.Geocoder(user_loc);
        ShowNewLoc();

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });

        $("#country_id").chosen({allow_single_deselect:true}).change(function () {
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text());
            ShowNewLoc();
            $('#profile-form div.row:eq(4)').hide();

            if ($(this).val() == 174) {
                $('#region_id_chzn').show();
                $('#region_id_chzn').parents('div.col').show();
                if ($('#region_id').val() != '' && $('#region_id').val() != 42 && $('#region_id').val() != 59) {
                    $('#city_name').show();
                }
            } else {
                $('#region_id_chzn').hide();
                $('#city_name').hide();
                $('#city_name').val('');
                $('#city_id').val('');
            }
        });

        $('#region_id').chosen({allow_single_deselect:true}).change(function () {
            //console.log($("#region_id option:selected").text());
            geocoder = new YMaps.Geocoder($("#country_id option:selected").text() + ", " + $("#region_id option:selected").text());
            ShowNewLoc();

            if ($(this).val() == '' || $(this).val() == 42 || $(this).val() == 59) {
                //$('#city_name').hide();
                $('#profile-form div.row:eq(4)').hide();

                if ($(this).val() == '') {
                } else {
                    if ($(this).val() == 42)
                        $('#city_id').val(148315);
                    if ($(this).val() == 59)
                        $('#city_id').val(148316);
                }
            } else {
                $('#profile-form div.row:eq(4)').show();
                $('#city_name').show();
                $('#city_id').val('');
                $('#city_name').val('');
            }
        });

        if ($('#country_id').val() != 174) {
            $('#city_name').hide();
        }

        $('form#profile-form').submit(function () {
            unsetPlaceholder(document.getElementById('city_name'));
            return true;
        });
    });

    function ShowNewLoc() {
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