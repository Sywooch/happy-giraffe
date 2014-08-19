<?php
/**
 * @var CActiveDataProvider $dp
 * @var string $letter
 */
?>

<div class="map-route">
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="heading-h1-hold">
                <h1 class="heading-link-xxl">Маршруты из городов на букву «<?=$letter?>»</h1>
            </div>
        </div>
    </div>
    <div class="b-main_cont">
        <div class="map-route-abc">
            <?php $this->widget('AlphabetWidget'); ?>
        </div>

        <?php
        $this->widget('LiteListView', array(
            'dataProvider' => $dp,
            'itemView' => '_city',
            'emptyText' => 'Нет ни одного маршрута по вашему запросу',
            'itemsCssClass' => 'map-route-list_ul',
            'htmlOptions' => array(
                'class' => 'map-route-list',
            ),
        ));
        ?>
    </div>
</div>