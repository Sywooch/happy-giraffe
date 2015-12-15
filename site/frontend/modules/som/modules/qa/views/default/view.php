<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 */
$this->sidebar = array('ask', 'personal', 'menu', 'rating');
$this->pageTitle = $question->title;
?>

<div class="question">
    <div class="live-user">
        <a href="<?=$question->user->profileUrl?>" class="ava ava ava__<?=($question->user->gender) ? 'male' : 'female'?>">
            <?php if ($question->user->isOnline): ?>
                <span class="ico-status ico-status__online"></span>
            <?php endif; ?>
            <?php if ($question->user->avatarUrl): ?>
                <img alt="" src="<?=$question->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <div class="username">
            <a href="<?=$question->user->profileUrl?>"><?=$question->user->fullName?></a>
            <?= HHtml::timeTag($question, array('class' => 'tx-date')); ?>
        </div>
    </div>
    <div class="icons-meta">
        <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span></div>
    </div>
    <div class="clearfix"></div>
    <h1 class="questions_item_heading"><?=$question->title?></h1>
    <div class="questions_item_category">
        <div class="questions_item_category_ico sharp-test"></div>
        <?php if ($question->consultationId === null): ?>
            <a href="<?=$this->createUrl('/som/qa/default/index/', array('categoryId' => $question->category->id))?>" class="questions_item_category_link"><?=$question->category->title?></a>
        <?php else: ?>
            <a href="<?=$this->createUrl('/som/qa/consultation/index/', array('consultationId' => $question->consultation->id))?>" class="questions_item_category_link"><?=$question->consultation->title?></a>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
    <div class="question_text">
        <?=$question->text?>
    </div>
</div>
<?php $this->widget('site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget', array('question' => $question)); ?>