<?php
/* @var $this Controller
 * @var $user User
 */
$regions = array('' => '');
if ($user->getUserAddress()->country_id !== null) {
    $regions = array('' => '') + CHtml::listData(GeoRegion::model()->findAll(array(
        'order' => 'id', 'select' => 'id,name', 'condition' => 'country_id = ' . $user->getUserAddress()->country_id)), 'id', 'name');
}
?>
<div id="locationEdit" class="popup">

    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="popup-title">Место жительства</div>

    <form method="post" action="<?php echo Yii::app()->createUrl('/user/saveLocation'); ?>" class="clearfix">
        <div class="form">
            <div class="row clearfix with-search">
                <div class="row-title">Страна</div>
                <div class="row-elements">
                    <?php echo CHtml::dropDownList('country_id', $user->getUserAddress()->country_id,
                    CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
                    array(
                        'class' => 'chzn w-300',
                        'data-placeholder' => 'Выберите страну',
                        'onchange' => 'UserLocation.SelectCounty($(this));'
                    )) ?>
                </div>
            </div>
            <div class="row clearfix with-search">
                <div class="row-title">Регион</div>
                <div class="row-elements">
                    <?php echo CHtml::dropDownList('region_id', $user->getUserAddress()->region_id, $regions,
                    array(
                        'class' => 'chzn w-300',
                        'data-placeholder' => 'Выберите регион',
                        'onchange' => 'UserLocation.RegionChanged($(this));'
                    )); ?>
                </div>
            </div>
            <div class="row clearfix settlement"<?php if ($user->getUserAddress()->region !== null && $user->getUserAddress()->region->isCity()) echo ' style="display:none;"' ?>>
                <div class="row-title">Населенный пункт</div>
                <div class="row-elements">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id' => 'city_name',
                        'name' => 'city_name',
                        'value' => ($user->userAddress->city === null) ? '' : $user->userAddress->city->name,
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
                                }
                            ",
                            'htmlOptions' => array(
                                'placeholder' => 'Выберите город'
                            )
                        ),
                    ));
                    ?>
                    <?php echo CHtml::hiddenField('city_id', $user->userAddress->city_id); ?>
                    <br>
                    Введите свой город, поселок, село или деревню
                </div>
            </div>
            <div class="row">
                <button class="btn btn-green-medium" onclick="UserLocation.saveLocation();return false;"><span><span>Сохранить</span></span></button>
            </div>
        </div>
    </form>

</div>