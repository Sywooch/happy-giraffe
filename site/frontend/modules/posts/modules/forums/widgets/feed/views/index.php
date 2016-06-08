<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget $this
 * @var CActiveDataProvider $dp
 */
?>

<div class="tabs">
    <?php $this->widget('zii.widgets.CMenu', [
        'items' => $this->getMenuItems(),
    ]); ?>
</div>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->getListDataProvider(),
    'itemView' => '_post',
    'tagName' => 'section',
    'htmlOptions' => [
        'class' => 'main-content',
    ],
));
?>