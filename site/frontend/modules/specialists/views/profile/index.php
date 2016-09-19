<?php
/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */

$this->pageTitle = $this->user->getFullName() . ' на Веселом Жирафе';
?>

<?php $this->renderPartial('_userSection', ['user' => $this->user]); ?>

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


