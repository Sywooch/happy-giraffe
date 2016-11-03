<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer
 */

$userName = Yii::app()->user->isGuest ? $answer->user->getAnonName() : $answer->user->getFullName();

$params = array(
    'questionId'                => $question->id,
    'categoryId'                => $question->categoryId,
    'pediatricianCategoryId'    => QaCategory::PEDIATRICIAN_ID,
    'channelId'                 => 'AnswersWidget_' . $question->id,
);

Yii::app()->clientScript->registerAMD('qa-answers', array('ko' => 'knockout', 'Answers' => 'qa/answers'), 'ko.applyBindings(new Answers(' . CJSON::encode($params) . '), $("#answers").get(0));');
?>
<?php if ($answer->authorIsSpecialist()) {?>
<div class="clearfix">
    <div class="questions-modification__avatar awatar-wrapper awatar-wrapper--theme-pediator pediator-answer__left--style">
    	<a href="<?=$answer->user->profileUrl?>" class="awatar-wrapper__link ava__b-pink">
    		<img src="<?=$answer->user->avatarUrl?>" class="awatar-wrapper__img">
    	</a>
    </div>
    <div class="pediator-answer__right pediator-answer__right-active">
        <div class="box-wrapper__user box-wrapper__user-mod margin-b0">
          	<a href="<?=$answer->user->profileUrl?>" class="box-wrapper__link"><?=$answer->user->getFullName()?></a>
          	<?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?>
        </div>
      	<div class="box-wrapper__user margin-b0">
      		<span class="display-ib font__color--crimson margin-t2 margin-b3">HARD CODE!</span>
    	</div>
      	<div class="box-wrapper__header box-header">
        	<p class="box-header__text height-auto"><?=$answer->text?></p>
      	</div>
    </div>
    <div class="pediator-answer__right pediator-answer__right--theme-pediator">
        <div class="box-wrapper__footer clearfix">
            <div class="answers-list_item_like-block usefull margin-l0" data-bind="click: vote(<?=$answer->id?>)">
            	<div class="answers-list_item_like-block_like"></div>
            	<div class="like_counter">Спасибо<span data-bind="text: '<?=$answer->votesCount?>', visible: <?=$answer->votesCount?> &gt; 0" style="display: none;"></span></div>
            </div>
        </div>
    </div>
</div>
<?php } else {?>
<div class="questions-modification__avatar awatar-wrapper">
	<a href="<?=$answer->user->profileUrl?>" class="ava ava__middle ava__<?=($answer->author->gender) ? 'male' : 'female'?>">
		<?php if ($answer->author->online): ?>
            <span class="ico-status ico-status__online"></span>
        <?php endif; ?>
        <?php if ($answer->author->avatarUrl): ?>
			<img src="<?=$answer->user->avatarUrl?>" class="awatar-wrapper__img">
		<?php endif;?>
	</a>
</div>
<div class="questions-modification__box questions-modification__box-w98 box-wrapper box-wrapper_mod">
    <div class="box-wrapper__user box-wrapper__user-mod margin-b0">
        <a href="<?=$answer->user->avatarUrl?>" class="box-wrapper__link"><?=$userName?></a>
        <?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?>
    </div>
    <div class="box-wrapper__header box-header">
        <p class="box-header__text height-auto"><?=$answer->text?></p>
    </div>
    <div class="box-wrapper__footer clearfix margin-t10">
        <div class="answers-list_item_like-block usefull margin-l0">
        <div class="answers-list_item_like-block_like"></div>
        <div class="like_counter">Спасибо<span data-bind="text: votesCount, visible: votesCount() &gt; 0" style="display: none;"></span></div>
        </div>
    </div>
</div>
<?php } ?>
