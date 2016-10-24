<?php

/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */
$this->pageTitle = 'Жираф педиатр - Ответы';

$answers = \site\frontend\modules\som\modules\qa\components\AnswerManagementData::process($dp->data)

?>

<?php if (count($answers)): ?>

    <div class="landing-question pediator pediator-top"">
        <div class="questions margin-t0">
            <ul class="items">
                <?php foreach ($answers as $answer): ?>
                    <single-answer params='answer: <?=HJSON::encode($answer)?>, hideLinks: true'></single-answer>
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
                        'pages'           => $dp->pagination,
                    ]);
                
                ?>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="landing-question pediator textalign-c">
    	<div class="pediator-ico-shape pediator-ico-shape--style"></div>
    	<p class="font-m color-grey-l margin-b40">
    		Здесь будут отображаться ваши ответы на вопросы пользователей.
    		<br>Вы пока не ответили ни на один вопрос.
    	</p>
    	<a href="/pediatrician/questions/" class="btn b-btn--xl green-btn">Перейти к вопросам</a>
    </div>

<?php endif; ?>

