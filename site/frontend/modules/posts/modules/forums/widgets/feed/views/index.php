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
