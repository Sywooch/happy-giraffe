<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\MyController $this
 * @var \CActiveDataProvider $dp
 */
$this->sidebar = array('my_answers' => array('categoryId' => $categoryId), 'my_rating');
$this->pageTitle = 'Мои ответы';
?>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '_answer',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));
?>