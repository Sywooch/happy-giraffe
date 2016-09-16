<?php

/**
 * @var \site\frontend\modules\posts\controllers\ListController $this
 */

$this->pageTitle = 'Жизнь';

$this->metaNoindex = true;

?>

<?php

$breadcrumbs = array(
    'Главная' => array('/site/index'),
    $this->pageTitle
);

?>

<div class="b-breadcrumbs" style="margin-left: 0;">

<?php 
        
$this->widget('zii.widgets.CBreadcrumbs', array(
    'links'                => $breadcrumbs,
    'tagName'              => 'ul',
    'homeLink'             => FALSE,
    'separator'            => '',
    'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
    'inactiveLinkTemplate' => '<li>{label}</li>',
));

?>

</div>

<?php

$this->widget('LiteListView', array(
    'dataProvider' => $this->listDataProvider,
    'itemView' => '_view',
    'tagName' => 'div',
    'htmlOptions' => array(
        'class' => 'b-main_col-article'
    ),
    'itemsTagName' => 'div',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));