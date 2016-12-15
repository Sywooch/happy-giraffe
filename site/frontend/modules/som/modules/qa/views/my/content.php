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

$mobileBlock =
'<div class="b-mobile-nav">
    <div class="b-mobile-nav__title">Мой педиатор</div>
    <div class="b-mobile-nav__right">
        <a href="<?=$this->createUrl("/som/qa/default/questionAddForm/")?>" class="b-mobile-nav__btn btn btn--default login-button" data-bind="follow: {}">Задать вопрос</a>
    </div>
</div>';

$this->widget('LiteListView', [
    'dataProvider'      => $dp,
    'itemView'          => $itemView,
    'additionalData'    => ['myAnswersPage' => TRUE],
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
            <a id="addNewQuestionBtn" class="disabled btn btn--xl btn--default login-button" href="<?=$this->createUrl('/som/qa/default/questionAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
        </div>
    <?php } ?>
</aside>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>