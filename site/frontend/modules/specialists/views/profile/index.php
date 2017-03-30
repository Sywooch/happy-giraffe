<?php

/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */

$this->pageTitle = $this->user->getFullName() . ' на Веселом Жирафе';

?>

<?php

$this->renderPartial('_userSection', [
    'user'  => $this->user
]);

?>

<div class="b-main__inner">
    <div class="b-col__container">
        <div class="block-center b-col--6 b-col-sm--10 b-col-xs">

            <?php

            $this->widget('zii.widgets.CMenu', [
                'htmlOptions'       => [
                    'class' => 'b-filter-menu__panel b-filter-menu__panel--anketa',
                ],
                'itemCssClass'      => 'b-filter-menu__items',
                'activeCssClass'    => 'b-filter-menu__link-anketa--active',
                'items'             => [
                    [
                        'label'         => 'Ответы',
                        'url'           => ['/specialists/profile/index', 'userId' => $this->user->id],
                        'linkOptions'   => [
                            'class' => 'b-filter-menu__link-anketa'
                        ],
                    ],
                    [
                        'label'         => 'Информация',
                        'url'           => ['/specialists/profile/info', 'userId' => $this->user->id],
                        'linkOptions'   => [
                            'class' => 'b-filter-menu__link-anketa'
                        ],
                    ],
                ],
            ]);

            ?>

            <?php

            $this->widget('LiteListView', [
                'dataProvider'          => $dp,
                'itemView'              => '_new_answer',
                'viewData'              => [
                    'user' => $this->user
                ],
                // 'additionalData'    => isset($votesList) ? ['votesList' => $votesList] : NULL,
                'htmlOptions'           => [
                    'class' => 'b-col b-col--6 b-col-sm--10 b-col-xs',
                ],
                'itemsTagName'          => 'ul',
                'itemsCssClass'         => 'b-answer b-answer--theme-pediator',
                'template'              => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
                'pager'                 => [
                    'class'           => 'LitePagerDots',
                    'prevPageLabel'   => '&nbsp;',
                    'nextPageLabel'   => '&nbsp;',
                    'showPrevNext'    => TRUE,
                    'showButtonCount' => 5,
                    'dotsLabel'       => '<li class="page-points">...</li>'
                ]
            ]);

            ?>

        </div>
    </div>
</div>

<?php if (0): ?>
<div class="b-main__inner">
    <div class="b-col__container">
        <div class="block-center b-col--6 b-col-sm--10 b-col-xs">
            <ul class="b-filter-menu__panel b-filter-menu__panel--anketa">
                <li class="b-filter-menu__items"><a href="javascript:void(0);" class="b-filter-menu__link-anketa b-filter-menu__link-anketa--active">Ответы</a>
                </li>
                <li class="b-filter-menu__items"><a href="javascript:void(0);" class="b-filter-menu__link-anketa">Информация</a>
                </li>
            </ul>
            <ul class="b-answer b-answer--theme-pediator">
                <li class="b-answer__item">
                    <div class="b-pediator-answer">
                        <div class="b-pediator-answer__left">
                            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                <a href="javascript:void(0);" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                        </div>
                        <div class="b-pediator-answer__right b-pediator-answer__right--pink">
                            <div class="b-answer__header b-answer-header"><a href="javascript:void(0);" class="b-answer-header__link">Мария, Москва</a>
                                <time class="b-answer-header__time">5 минут назад</time>
                                <div class="b-answer-header__spezialisation">педиатр, детский хирург</div>
                                <div class="b-answer-header__box b-answer-header-box">
                                    <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                                    </div>
                                    <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span>
                                                    <span
                                                            class="b-answer-header-box__ico"></span>
                                                        </span><span class="b-text-color--grey b-text--size-12">869</span>
                                    </div>
                                </div>
                            </div>
                            <div class="b-answer__body b-answer-body">
                                <p class="b-pediator-answer__text">Добрый день. Конечно же можно. Но только нужно гулять чтобы была комфортная температура для ребенка, не кутайте его. и поменьше контактируйте с другими людьми. Можно подключить противовоспалительные препараты
                                    для носа или противовирусные средства: Назаваль плюс, Анаферон, Гриппферон, Виферон. Можно выбрать любое из этих средств, только внимательно посмотрите на необходимую дозировку.</p><a href="javascript:void(0);"
                                                                                                                                                                                                                            class="b-text--link-color b-title--bold b-title--h9">Зеленые сопли у грудничка</a>
                            </div>
                        </div>
                        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
                            <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__age b-text--link-color">1 - 12</a>
                            </div>
                            <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__comment">10</a>
                                <button type="button" class="btn-answer btn-answer--theme-green btn-answer--active"><span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="yiipagination">
                <div class="pager">
                    <ul class="yiiPager">
                        <li class="previous">
                            <a href="javascript:void(0);"></a>
                        </li>
                        <li class="page"><a href="javascript:void(0);">1</a>
                        </li>
                        <li class="page"><a href="javascript:void(0);">2</a>
                        </li>
                        <li class="page-points"><a href="javascript:void(0);">3</a>
                        </li>
                        <li class="page selected"><a href="javascript:void(0);">7</a>
                        </li>
                        <li class="page"><a href="javascript:void(0);">8</a>
                        </li>
                        <li class="page hidden"><a href="javascript:void(0);">9</a>
                        </li>
                        <li class="page-points">...</li>
                        <li class="page"><a href="javascript:void(0);">15</a>
                        </li>
                        <li class="page"><a href="javascript:void(0);">16</a>
                        </li>
                        <li class="next">
                            <a href="javascript:void(0);"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (0): ?>

<div class="landing-question pediator margin-t50">
    <div class="questions margin-t0">
        <ul class="items">
            <?php foreach (\site\frontend\modules\som\modules\qa\components\AnswerManagementData::process($dp->data) as $answer): ?>
                <single-answer params='answer: <?=HJSON::encode($answer)?>'></single-answer>
            <?php endforeach; ?>
        </ul>
        <div class="yiipagination yiipagination__center">
            <div class="pager">
                <?php
                $this->widget('LitePagerDots', [
                    'prevPageLabel'   => '&nbsp;',
                    'nextPageLabel'   => '&nbsp;',
                    'showPrevNext'    => TRUE,
                    'showButtonCount' => 5,
                    'dotsLabel'       => '<li class="page-points">...</li>',
                    'pages' => $dp->pagination,
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>