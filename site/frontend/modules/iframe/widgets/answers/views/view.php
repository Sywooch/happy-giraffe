<?php
/**
 * @var site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget $this
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer[] $bestAnswers
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer[] $otherAnswers
 */
?>

<div class="answer-form">
    <!-- ava--><a href="#" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a>
    <textarea placeholder="Введите ваш ответ" class="answer-form_textarea login-button" data-bind="follow: {}"></textarea>
    <div class="clearfix"></div>
    <div class="answer-form_button btn btn-primary btn-s login-button" data-bind="follow: {}">Ответить</div>
</div>
<div class="clearfix"></div>

<?php if (count($otherAnswers) > 0)
{
    ?>
    <div class="answers">

    	<?php if (count($bestAnswers)): ?>

            <ul class="answers-list best-answer">
                <?php foreach ($bestAnswers as $data): ?>
                    <?php $this->controller->renderPartial('/_answer', array('data' => $data)); ?>
        		<?php endforeach; ?>
            </ul>

        <?php endif; ?>

        <div class="answers_heading">Ответы:<span><?= count($otherAnswers) ?></span></div>
        <ul class="answers-list all-answers">
            <?php foreach ($otherAnswers as $data): ?>
                <?php $this->controller->renderPartial('/_answer', compact('data')); ?>
    <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>