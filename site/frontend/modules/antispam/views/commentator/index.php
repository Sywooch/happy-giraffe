<?php
/**
 * @var CommentatorController $this
 * @var CActiveDataProvider $dp
 * @var $menuItems
 */
?>
<style>
li.active > a {
    color: #000;
    text-decoration: none;
}
</style>
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => $menuItems,
));

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dp,
    'itemView' => '/default/_content/comment',
));
?>