<?php
$this->pageTitle = 'Врачи';
?>
<div class="b-nav-panel">
    <div class="b-nav-panel__left">
        <div class="b-filter-menu b-filter-menu--theme-default">
            <ul class="b-filter-menu__list">
                <li class="b-filter-menu__item">
                    <a href="<?=$this->createUrl('/iframe/default/pediatricianList')?>" class="b-filter-menu__link b-filter-menu__link--active">Все</a>
                </li>
<!--                <li class="b-filter-menu__item">-->
<!--                    <a href="#" class="b-filter-menu__link">Из Ниж.Новогорода</a>-->
<!--                </li>-->
            </ul>
        </div>
    </div>
</div>
<?php
$this->widget('site\frontend\modules\iframe\components\LiteListView', [
    'dataProvider'      => $dp,
    'itemView'          => '_pediatrician-list',
    'additionalData'    => NULL,
    'htmlOptions'       => [
        'class' => 'b-pediatrician-list',
    ],
    'itemsTagName'      => 'ul',
    'itemsCssClass'     => 'b-pediatrician-list-ul clearfix',
    'template'          => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager'             => [
        'class'           => 'LitePagerDots',
        'prevPageLabel'   => '&nbsp;',
        'nextPageLabel'   => '&nbsp;',
        'showPrevNext'    => TRUE,
        'showButtonCount' => 5,
        'dotsLabel'       => '<li class="page-points">...</li>'
    ]
]);
?>
