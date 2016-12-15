<?php
/**
 * @var AnswersWidget $this
 * @var QaQuestion $question
 */
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;

?>
<div class="answer-form">
    <!-- ava--><a href="#" class="ava ava__middle ava__female"><span
                class="ico-status ico-status__online"></span><img
                alt="" src="" class="ava_img"></a>
    <textarea placeholder="Введите ваш ответ" class="answer-form_textarea login-button"
              data-bind="follow: {}"></textarea>
    <div class="clearfix"></div>
    <div class="answer-form_button btn btn-primary btn-s login-button" data-bind="follow: {}">Ответить</div>
</div>
<div class="clearfix"></div>

<div class="answers">

    <div class="answers_heading">Ответы:<span><?= $question->answerManager->getAnswersCount() ?></span></div>
    <ul class="questions margin-t40">
        <? foreach ($question->answerManager->getAnswers() as $answer): ?>
            <?= $this->render('_answer', ['answer' => $answer]) ?>
        <? endforeach; ?>
    </ul>

</div>