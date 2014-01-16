<?php
/**
 * @var CActiveDataProvider $dp
 */
?>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dp,
    'itemView' => '_check',
));
?>