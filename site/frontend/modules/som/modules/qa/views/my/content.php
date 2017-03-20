<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\MyController $this
 * @var \CActiveDataProvider $dp
 */

$isAnswer = $this->action->id == 'answers';

if ($isAnswer)
{
    $this->pageTitle = 'Мои ответы';
    $itemView = '/_new_answers';
} else {
    $this->pageTitle = 'Мои вопросы';
    $itemView = '/_new_question';
}
?>
<div class="b-main__inner">
    <div class="b-col__container">
        <div class="b-col b-col--6 b-col-sm--10 b-col-xs">
            <div class="b-nav-panel">
                <div class="b-nav-panel__left">
                    <div class="b-filter-menu b-filter-menu--theme-default">
                        <p class="js-mobile-dropdown mobile-dropdown-button">Все ответы</p>
                        <ul class="b-filter-menu__list">
                            <li class="b-filter-menu__item">
                            	<a href="<?=$this->createUrl('/som/qa/my/questions')?>" class="b-filter-menu__link <?=$this->action->id == 'questions' ? 'b-filter-menu__link--active' : ''?>">Мои вопросы</a>
                            </li>
                            <li class="b-filter-menu__item">
                            	<a href="<?=$this->createUrl('/som/qa/my/answers')?>" class="b-filter-menu__link <?=$this->action->id == 'answers' ? 'b-filter-menu__link--active' : ''?>">Мои ответы</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $mobileBlock =
        '<div class="b-mobile-nav">
            <div class="b-mobile-nav__title">Мой педиатр</div>
            <div class="b-mobile-nav__right">
                <a href="<?=$this->createUrl("/som/qa/default/questionAddForm/")?>" class="b-mobile-nav__btn btn btn--default login-button" data-bind="follow: {}">Задать вопрос</a>
            </div>
        </div>';

        $this->widget('LiteListView', [
            'dataProvider'      => $dp,
            'itemView'          => $itemView,
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
        <aside class="b-main__aside b-col b-col--3 b-hidden-md">
        	<?php if ($isAnswer) {
                $this->widget('site\frontend\modules\som\modules\qa\widgets\Statistic\CommonStatistic', ['userId' => \Yii::app()->user->id]);
            } else { ?>
                <div class="b-text--center">
                    <a id="addNewQuestionBtn" class="disabled btn btn--xl btn--default login-button" href="<?=$this->createUrl('/som/qa/default/pediatricianAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
                </div>
            <?php } ?>
        </aside>
    </div>
</div>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>