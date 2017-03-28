<?php

use site\frontend\modules\specialists\modules\pediatrician\helpers\AnswersTree;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager as MPQaManager;

/**
 * @var \site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 */

$this->pageTitle = $question->title;

$answerTreeHelper = new AnswersTree();
$answerTreeHelper->init($question->getSpecialistDialog(\Yii::app()->user->id));

$currentAnswerId = $answerTreeHelper->getCurrentAnswerForSpecialist();

$jsParams = [
    $question->id
];

if (!is_null($currentAnswerId))
{
    $jsParams[] = $currentAnswerId->id;
    $jsParams[] = CJSON::encode( \site\common\helpers\HStr::truncate($currentAnswerId->text, 150) );
    $jsParams[] = (int) QaManager::isAnswerEditing($currentAnswerId->id);
}

$jsParamsStr = implode(',', $jsParams);

?>

<!-- ko stopBinding: true -->
<div class="landing-question pediator pediator-top padding-b50" id="pediatrician-reply" style="display: none" data-bind="visible: true">
    <div class="b-contest-winner__container">
        <div class="question">
            <div class="live-user position-rel">
                <div class="username"><span class="font__color--blue"><?=$question->user->firstName?></span>
                    <?=HHtml::timeTag($question, ['class' => 'tx-date'])?>
                </div>
            </div>
            <span class="questions_item_heading"><?=$question->title?></span>
            <?php if ($question->tag): ?>
                <div class="pediator-answer__footer-box">
                    <div class="box-wrapper__footer box-footer"><a href="<?=UrlCreator::create('/pediatrician/questions/', ['filter' => ['tag' => $question->tag->id]]);?>" class="box-footer__cat"><?=$question->tag->name?></a></div>
                </div>
            <?php endif; ?>
            <div class="question_text">
                <?=$question->text?>
            </div>
            <ul class="all-answers float-l margin-t15">
            	<?=$answerTreeHelper->render()?>
        	</ul>
        </div>
            <?php /**
                foreach ($question->answers as $answer)
                {
                    $this->renderPartial('_answer', ['data' => $answer]);
                } **/
            ?>
        <div class="queastion__page-nav clearfix" data-bind="visible: ! replyMode()">
            <div class="float-l"><span class="btn btn-xl btn-secondary" data-bind="click: skip">Пропустить</span></div>
            <div class="float-r"><span class="btn btn-xl green-btn" data-bind="click: openForm">Ответить</span></div>
        </div>

        <form class="answer-form" data-bind="visible: replyMode()">
            <div class="redactor-control">
                <?php $this->widget('Avatar', [
                    'user' => Yii::app()->user->model,
                    'tag' => 'span',
                    'size' => Avatar::SIZE_SMALL,
                ]); ?>
                <div class="redactor-control_hold" style="padding-left: 8%">
                    <textarea placeholder="Введите ваш ответ" class="answer-form_textarea" data-bind="wswgHG: { config : editorConfig, attr : answerText  }"></textarea>
                </div>
            </div>

            <div class="answer-form__footer clearfix">
                <div class="answer-form__footer-panel">
                    <div id="add-post-toolbar"></div>
                </div>
                <div class="textalign-r">
                    <div class="answer-form_button btn btn-primary btn-s" data-bind="click: reply, css: {'disabled': isAnswerEditing() || isAnswerRemoved()}">Ответить</div>
                    <a class="btn btn-ms btn-secondary margin-t6 margin-r10" href="<?=$this->createUrl('/specialists/pediatrician/default/questions')?>">Отменить</a>
                </div>
            </div>

        </form>
    </div>
</div>
<!-- /ko -->

<?php

/**
 * @var CClientScript $cs
 */
$cs = Yii::app()->clientScript;

$js = <<<JS
    setTimeout(function() {
        ko.applyBindings(new ReplyForm($jsParamsStr), document.getElementById("pediatrician-reply"));
    }, 100);
JS;

$cs->registerAMD(
    'pediatrician-reply',
    [
        'ReplyForm' => 'specialists/pediatrician/reply',
        'ko'        => 'knockout'
    ],
    $js
);

$cs->registerAMD(
    'Realplexor-reg',
    [
        'common',
        'comet'
    ],
    'comet.connect(\'http://' . \Yii::app()->comet->host . '\', \'' . \Yii::app()->comet->namespace . '\', \'' . MPQaManager::getQuestionChannelId($question->id) . '\');'
);

?>

<?php //$this->widget('site\frontend\modules\specialists\modules\pediatrician\answers\AnswersWidget', array('question' => $question)); ?>
