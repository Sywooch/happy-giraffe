<?php
/**
 * @var site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget $this
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer $bestAnswer
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer[] $answers
 */
?>

<div class="answer-form">
    <div class="answer-form_heading">Ваш ответ на вопрос</div>
    <!-- ava--><a href="#" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a>
    <textarea placeholder="Введите ваш ответ" class="answer-form_textarea"></textarea>
    <div class="clearfix"></div>
    <div class="answer-form_button btn btn-primary btn-s">Ответить</div>
</div>
<div class="clearfix"></div>

<div class="answers">
    <div class="answers_heading">Лучший ответ</div>
    <ul class="answers-list best-answer">
        <?php $this->render('_answer', array('data' => $bestAnswer)); ?>
    </ul>
    <div class="answers_heading">Ответы:<span><?=count($answers)?></span></div>
    <ul class="answers-list all-answers">
        <?php foreach ($answers as $data): ?>
            <?php $this->render('_answer', compact('data')); ?>
        <?php endforeach; ?>
    </ul>
</div>