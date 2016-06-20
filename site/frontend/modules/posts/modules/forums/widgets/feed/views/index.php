<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget $this
 * @var CActiveDataProvider $dp
 */
?>


<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->getListDataProvider(),
    'itemView' => '_post',
    'htmlOptions' => [
        'class' => 'b-main_col-article',
    ],
));
?>

<?php if (false): ?>
<div class="tabs">
    <?php $this->widget('zii.widgets.CMenu', [
        'items' => $this->getFilterItems(),
    ]); ?>
</div>

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

<?php endif; ?>
