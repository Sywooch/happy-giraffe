<?php
/**
 * @var \site\frontend\modules\posts\controllers\ListController $this
 */
$this->pageTitle = 'Новости с Весёлым Жирафом';
$this->metaNoindex = true;
 

if (isset($this->club->title)) 
{
    $this->breadcrumbs = array(
        $this->pageTitle => $this->createUrl('/som/community/news/index'),
        $this->club->title
    );
}
else
{
    $this->breadcrumbs = array(
        $this->pageTitle
    );
}

?>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->listDataProvider,
    'itemView' => 'site.frontend.modules.posts.views.list._view',
    'tagName' => 'div',
    'htmlOptions' => array(
        'class' => 'b-main_col-article'
    ),
    'itemsTagName' => 'div',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));
?>
