<?php
/**
 * @var \site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 */

$this->pageTitle = $question->title;
Yii::app()->clientScript->registerAMD('pediatrician-reply', ['ReplyForm' => 'specialists/pediatrician/reply', 'ko' => 'knockout'], 'ko.applyBindings(new ReplyForm(' . $question->id . '), document.getElementById("pediatrician-reply"));');
?>

<div class="landing-question pediator pediator-top padding-b50" id="pediatrician-reply" style="display: none" data-bind="visible: true">
    <div class="b-contest-winner__container">
        <div class="question">
            <div class="live-user position-rel">
                <div class="username"><a href="<?=$question->user->profileUrl?>"><?=$question->user->getFullName()?></a>
                    <?=HHtml::timeTag($question, ['class' => 'tx-date'])?>
                </div>
            </div><span class="questions_item_heading"><?=$question->title?></span>
            <?php if ($question->tag): ?>
                <div class="pediator-answer__footer-box">
                    <div class="box-wrapper__footer box-footer"><a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $question->categoryId, 'tagId' => $question->tag->id])?>" class="box-footer__cat"><?=$question->tag->name?></a></div>
                </div>
            <?php endif; ?>
            <div class="question_text">
                <?=$question->text?>
            </div>
            <div class="queastion__page-nav clearfix" data-bind="visible: ! replyMode()">
                <div class="float-l"><span class="btn btn-xl btn-secondary" data-bind="click: skip">Пропустить</span></div>
                <div class="float-r"><span class="btn btn-xl green-btn" data-bind="click: openForm">Ответить</span></div>
            </div>
        </div>
        <form class="answer-form" data-bind="visible: replyMode">
            <div class="answer-form__header clearfix">
                <?php $this->widget('Avatar', [
                    'user' => Yii::app()->user->model,
                    'tag' => 'span',
                    'size' => Avatar::SIZE_SMALL,
                ]); ?>

                <div class="redactor-control">
                    <div class="redactor-control_toolbar"></div>
                    <div class="redactor-control_hold">
                        <textarea placeholder="Введите ваш ответ" class="answer-form_textarea" data-bind="wswgHG: { config : editorConfig, attr : answerText }"></textarea>
                    </div>
                </div>
            </div>
            <div class="answer-form__footer clearfix">
                <div class="answer-form__footer-panel">
                    <div id="add-post-toolbar"></div>
                </div>
                <div class="answer-form_button btn btn-primary btn-s" data-bind="click: reply">Ответить</div>
            </div>
        </form>
    </div>
</div>

