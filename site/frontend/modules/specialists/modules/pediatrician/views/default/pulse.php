<?php
/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */
$this->pageTitle = 'Жираф педиатр - Пульс';
?>

<div class="landing-question pediator pediator-top"">
<div class="questions">
    <ul class="items">
        <?php foreach (\site\frontend\modules\som\modules\qa\components\AnswerManagementData::process($dp->data) as $answer): ?>
            <single-answer params='answer: <?=HJSON::encode($answer)?>, hideLinks: true, showButtons: false'></single-answer>
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