<?php

use site\frontend\modules\som\modules\qa\controllers\DefaultController;

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \CActiveDataProvider $dp
 * @var string $tab
 */
$this->pageTitle = 'Мой педиатр';

$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Мой педиатр',
];
?>
<div class="b-col b-col--6 b-hidden-md">
	<div class="b-breadcrumbs b-breadcrumbs--theme-default">
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', [
            'links'                => $breadcrumbs,
            'tagName'              => 'ul',
            'homeLink'             => FALSE,
            'separator'            => '',
            'htmlOptions'          => ['class' => 'b-breadcrumbs__list'],
            'activeLinkTemplate'   => '<li class="b-breadcrumbs__item"><a href="{url}" class="b-breadcrumbs__link">{label}</a></li>',
            'inactiveLinkTemplate' => '<li class="b-breadcrumbs__item">{label}</li>',
        ]);
        ?>
    </div>
    <div class="b-nav-panel">
        <?php /* -------------- TABS -------------- */?>
        <div class="b-nav-panel__left">
            <div class="b-filter-menu b-filter-menu--theme-default">
                <ul class="b-filter-menu__list">
                    <li class="b-filter-menu__item <?=$tab == $this::TAB_NEW ? 'b-filter-menu__item--active' : ''?>">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician')?>" class="b-filter-menu__link">Новые</a>
                	</li>
                    <li class="b-filter-menu__item <?=$tab == $this::TAB_UNANSWERED ? 'b-filter-menu__item--active' : ''?>">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => $this::TAB_UNANSWERED])?>" class="b-filter-menu__link">Без ответа</a>
                    </li>
                    <li class="b-filter-menu__item <?=$tab == $this::TAB_All ? 'b-filter-menu__item--active' : ''?>">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => $this::TAB_All])?>" class="b-filter-menu__link">Все ответы</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php /* -------------- Search -------------- */?>
        <div class="b-nav-panel__right">
            <?php $this->renderPartial('/_new_search', array('query' => '')); ?>
        </div>
        <?php /* ---------------------------- */?>
    </div>
</div>

<?php
$mobileBlock =
'<div class="b-mobile-nav">
    <div class="b-mobile-nav__title">Мой педиатор</div>
    <div class="b-mobile-nav__right"><a href="javascript:voit(0);" class="b-mobile-nav__btn btn btn--default">Задать вопрос</a>
    </div>
</div>';

$itemView = '/_new_question';

if ($tab == $this::TAB_All)
{
    $itemView = '/_new_answers';
}

$this->widget('LiteListView', [
    'dataProvider'      => $dp,
    'itemView'          => $itemView,
    'additionalData'    => isset($votesList) ? $votesList : NULL,
    'htmlOptions'       => [
        'class' => 'b-col b-col--6 b-col-sm--10 b-col-xs',
    ],
    'itemsTagName'      => 'ul',
    'itemsCssClass'     => 'b-answer b-answer--theme-pediator',
    'template'          => $mobileBlock . '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
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