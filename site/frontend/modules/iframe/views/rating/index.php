<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\RatingController $this
 * @var \CActiveDataProvider $dp
 */
$this->sidebar = array('personal', 'menu');
$this->pageTitle = 'Рейтинг';
?>
<!-- <div class="heading-link-xxl"> Рейтинг</div> -->
<?php
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array(
        'class' => 'filter-menu',
    ),
    'itemCssClass' => 'filter-menu_item',
    'items' => array_map(function($periodData, $periodId)
    {
        return array(
            'label' => $periodData['label'],
            'url' => array('/som/qa/rating/index', 'period' => $periodId),
            'linkOptions' => array('class' => 'filter-menu_item_link'),
            'active' => Yii::app()->request->getQuery('period') == $periodId,
        );
    }, Yii::app()->controller->module->periods, array_keys(Yii::app()->controller->module->periods)),
));
?>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '_row',
    'htmlOptions' => array(
        'class' => 'faq-rating'
    ),
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));
?>
