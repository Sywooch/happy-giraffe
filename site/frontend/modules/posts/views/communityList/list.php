<?php

$this->pageTitle = $this->forum->title;
$this->metaNoindex = true;
$this->breadcrumbs = array(
    $this->club->title => $this->club->getUrl(),
);
$forumTitle = (isset($this->club->communities) && count($this->club->communities) > 1) ? $this->forum->title : 'Форум';
if ($this->rubric) {
    if (isset($this->club->communities) && count($this->club->communities) > 1) {
        $this->breadcrumbs[$forumTitle] = $this->forum->getUrl();
    }
    $this->breadcrumbs[] = $this->rubric->title;
} else {
    $this->breadcrumbs[] = $forumTitle;
}
$this->widget('LiteListView', array(
    'dataProvider' => $this->listDataProvider,
    'itemView' => 'site.frontend.modules.posts.views.list._view',
    'tagName' => 'div',
    'htmlOptions' => array(
        'class' => 'b-main_col-article'
    ),
    'itemsTagName' => 'div',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => array(
        'class' => 'LitePager',
        'maxButtonCount' => 10,
        'prevPageLabel' => '&nbsp;',
        'nextPageLabel' => '&nbsp;',
        'showPrevNext' => true,
    ),
));
