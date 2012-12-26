<?php
/* @var $this Controller
 * @var $user User
 */
$regions = array('' => '');
if ($user->address->country_id !== null) {
    $regions = array('' => ' ') + CHtml::listData(GeoRegion::model()->findAll(array(
        'order' => 'position, name', 'select' => 'id,name', 'condition' => 'country_id = ' . $user->address->country_id)), 'id', 'name');
}
?>
<div class="user-map">
    <div class="header">
        <div class="box-title">Я здесь</div>
        <div class="sep"><img src="/images/map_marker.png"></div>
    </div>

    <form method="post" action="<?php echo Yii::app()->createUrl('/user/saveLocation'); ?>" class="clearfix">
        <div class="row">
            <label>Место жительства</label>
        <span class="with-search">
        <?php echo CHtml::dropDownList('country_id', $user->address->country_id,
            array('' => ' ') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
            array(
                'class' => 'chzn w-100',
                'data-placeholder' => 'Страна',
                'onchange' => 'UserLocation.SelectCounty($(this));',
            )) ?>
            </span>&nbsp;&nbsp;
        <span class="with-search">
                <?php echo CHtml::dropDownList('region_id', $user->address->region_id, $regions,
            array(
                'class' => 'chzn w-200',
                'data-placeholder' => 'Регион',
                'onchange' => 'UserLocation.RegionChanged($(this));'
            )); ?>
        </span>
        </div>
        <div class="row settlement"<?php
            if ($user->address->region !== null
                && $user->address->region->isCity()
            ) echo ' style="display:none;"' ?>>
            <label>Населенный пункт</label>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'city_name',
                'name' => 'city_name',
                'value' => ($user->address->city === null) ? '' : $user->address->city->name,
                'source' => "js: function(request, response){
                            $.ajax({
                                url: '" . $this->createUrl('/geo/default/cities') . "',
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
                                }
                            ",
                    'htmlOptions' => array(
                        'placeholder' => 'Выберите город'
                    )
                ),
            ));
            ?>
            <?php echo CHtml::hiddenField('city_id', $user->address->city_id); ?>
            <small>Введите свой город, поселок, село или деревню</small>
        </div>
        <div class="row">
            <button class="btn btn-green-medium" onclick="UserLocation.saveLocation();return false;">
                <span><span>Сохранить</span></span>
            </button>
        </div>
    </form>
</div>