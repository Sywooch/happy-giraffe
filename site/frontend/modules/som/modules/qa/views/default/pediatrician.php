<?php

use site\frontend\modules\som\modules\qa\controllers\DefaultController;
use site\frontend\modules\som\modules\qa\models\QaTag;

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

$tabTitle = [
    $this::TAB_NEW          => 'Новые',
    $this::TAB_UNANSWERED   => 'Без ответа',
    $this::TAB_All          => 'Все ответы',
];

$currentTagId = \Yii::app()->request->getParam('tagId');

if (!is_null($currentTagId))
{
    $tag = QaTag::model()->findByPk($currentTagId);
    if (is_object($tag))
    {
        $breadcrumbs = [
            'Главная' => ['/site/index'],
            'Мой педиатр' => [$this->createUrl('/mypediatrician')],
            $tag->name,
        ];
    }
}
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
</div>
<div class="b-col b-col--6 b-col-sm--10 b-col-xs">
    <div class="b-mobile-nav">
        <div class="b-mobile-nav__title">Мой педиатр</div>
        <div class="b-mobile-nav__right">
            <a href="<?=$this->createUrl("/som/qa/default/pediatricianAddForm/")?>" class="b-mobile-nav__btn btn btn--default login-button" data-bind="follow: {}">Задать вопрос</a>
        </div>
    </div>
    <div class="b-nav-panel">
        <?php /* -------------- TABS -------------- */?>
        <div class="b-nav-panel__left">
            <div class="b-filter-menu b-filter-menu--theme-default">
                <p class="js-mobile-dropdown mobile-dropdown-button"><?=array_key_exists($tab, $tabTitle) ? $tabTitle[$tab] : 'Все ответы'?></p>
                <ul class="b-filter-menu__list">
                    <li class="b-filter-menu__item">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician')?>" class="b-filter-menu__link <?=$tab == $this::TAB_NEW ? 'b-filter-menu__link--active' : ''?>"><?=$tabTitle[$this::TAB_NEW]?></a>
                	</li>
                    <li class="b-filter-menu__item">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => $this::TAB_UNANSWERED])?>" class="b-filter-menu__link <?=$tab == $this::TAB_UNANSWERED ? 'b-filter-menu__link--active' : ''?>"><?=$tabTitle[$this::TAB_UNANSWERED]?></a>
                    </li>
                    <li class="b-filter-menu__item">
                    	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => $this::TAB_All])?>" class="b-filter-menu__link <?=$tab == $this::TAB_All ? 'b-filter-menu__link--active' : ''?>"><?=$tabTitle[$this::TAB_All]?></a>
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
$itemView = '/_new_question';

if ($tab == $this::TAB_All)
{
    $itemView = '/_new_answers';
}

$this->widget('LiteListView', [
    'dataProvider'      => $dp,
    'itemView'          => $itemView,
    'additionalData'    => isset($votesList) ? ['votesList' => $votesList] : NULL,
    'htmlOptions'       => [
        'class' => 'b-col b-col--6 b-col-sm--10 b-col-xs',
    ],
    'itemsTagName'      => 'ul',
    'itemsCssClass'     => 'b-answer b-answer--theme-pediator',
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