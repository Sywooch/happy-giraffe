<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 */
$this->sidebar = array('ask', 'personal', 'menu' => array('categoryId' => $question->categoryId), 'rating');

$this->pageTitle = CHtml::encode($question->title);

$this->breadcrumbs['Ответы'] = array('/som/qa/default/index');

if ($question->consultationId !== null)
{
    $this->breadcrumbs[$question->consultation->title] = array('/som/qa/consultation/index/', 'consultationId' => $question->consultation->id);
}
elseif ($question->categoryId !== null)
{
    $this->breadcrumbs[$question->category->title] = array('/som/qa/default/index/', 'categoryId' => $question->category->id);
}
$this->breadcrumbs[] = $question->title;

if (! is_null($question->category))
{
    $isAnonQuestion = $question->category->isPediatrician();
}
else
{
    $isAnonQuestion = FALSE;
}

?>

<div class="question">
    <div class="live-user">

    	<?php if (! $isAnonQuestion): ?>

        <a href="<?=$question->user->profileUrl?>" class="ava ava ava__<?=($question->user->gender) ? 'male' : 'female'?>">
            <?php if ($question->user->isOnline): ?>
                <span class="ico-status ico-status__online"></span>
            <?php endif; ?>
            <?php if ($question->user->avatarUrl): ?>
                <img alt="" src="<?=$question->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>

        <?php endif; ?>

        <div class="username">

        	<?php if ($isAnonQuestion): ?>
        		<span class="anon-name"><?php echo $question->user->getAnonName(); ?></span>
        	<?php else: ?>

        		<a href="<?=$question->user->profileUrl?>"><?=$question->user->fullName?></a>

        	<?php endif; ?>

            <?= HHtml::timeTag($question, array('class' => 'tx-date')); ?>

        </div>
    </div>
    <div class="icons-meta">
        <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span></div>
    </div>
    <div class="clearfix"></div>
    <h1 class="questions_item_heading"><?=strip_tags($question->title)?></h1>
    <?php if ($question->consultationId !== null || $question->categoryId !== null): ?>
    <div class="questions_item_category">
        <?php if ($question->consultationId !== null): ?>
            <a href="<?=$this->createUrl('/som/qa/consultation/index/', array('consultationId' => $question->consultation->id))?>" class="questions_item_category_link"><?=$question->consultation->title?></a>
        <?php else: ?>
            <div class="hashtag hashtag_mobile margin-t18">
            	<a href="<?=$this->createUrl('/som/qa/default/index/', array('categoryId' => $question->category->id))?>" class=""><?=$question->category->title?></a>
            	<?php if (!is_null($question->tag)): ?>
          			<a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $question->category->id, 'tagId' => $question->tag->id])?>" class=""><?=$question->tag->name?></a>
          		<?php endif; ?>
        	</div>
        	<a href="#" class="box-footer__answer box-footer__answer_blue box-footer__answer_mod">
        		<span class="box-footer__num"><?=$question->answersCount?></span>
        		<span class="box-footer__descr">ответов</span>
    		</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="question_text">
        <?=$question->purified->text?>
    </div>

    <?php $this->renderPartial('/default/navigation_arrow', array('next' => $this->getNextQuestions($question->id, $tab, $category), 'previous' => $this->getPrevQuestions($question->id, $tab, $category))); ?>

    <?php if (Yii::app()->user->checkAccess('manageQaQuestion', array('entity' => $question))): ?>
        <question-settings params="questionId: <?=$question->id?>"></question-settings>
    <?php endif; ?>
    
    <div class="clearfix"></div>
</div>


<?php $this->widget('site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget', array('question' => $question)); ?>