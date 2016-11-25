<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer
 */

$userName = Yii::app()->user->isGuest ? $answer->user->getAnonName() : $answer->user->getFullName();

$params = array(
    'questionId'                => $answer->questionId,
    'categoryId'                => $answer->question->categoryId,
    'pediatricianCategoryId'    => QaCategory::PEDIATRICIAN_ID,
    'channelId'                 => 'AnswersWidget_' . $answer->questionId,
);
$paramsParts = array_map(function($value, $key) {
    return $key . ': ' . \CJSON::encode($value);
}, $params, array_keys($params));

    $paramsStr = implode(', ', $paramsParts);
?>
<?php if ($answer->isAdditional()):?>
<?php echo \CHtml::tag('answers-additional', array('params' => $paramsStr)) ?>
<?php /**
<div class="pediator-answer__full margin-b20">
	<div class="box-wrapper__user box-wrapper__user-mod margin-b0">
		<a href="<?=$answer->user->profileUrl?>" class="box-wrapper__link"><?=$answer->user->getAnonName()?></a>
		<?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?>
		<span class="statistik__text--green font__upper font-sx font__semi"><?= $answer->user->gender == 1 ? 'ЗАДАЛА' : 'ЗАДАЛ' ?> ВОПРОС</span>
	</div>
	<div class="box-wrapper__header box-header">
      <p class="box-header__text height-auto"><?=$answer->text?></p>
    </div>
</div>
**/?>
<?php endif;?>
<?php if ($answer->isAnswerToAdditional()):?>
<?php echo \CHtml::tag('answers-additional', array('params' => $paramsStr))?>
<?php /**
<div class="float-l">
    <div class="awatar-wrapper awatar-wrapper--theme-pediator awatar-wrapper--theme-pediator pediator-answer__left--style">
    	<a href="<?=$answer->user->profileUrl?>" class="ava ava__small ava__<?=($answer->author->gender) ? 'male' : 'female'?> ava__b-pink">
			<img src="<?=$answer->user->avatarUrl?>" class="awatar-wrapper__img">
	</a>
	</div>
    <div class="clearfix pediator-answer__right--504">
        <div class="float-l pediator-answer--all pediator-answer__right-active">
            <div class="box-wrapper__user box-wrapper__user-mod margin-b0">
            	<a href="<?=$answer->user->profileUrl?>" class="box-wrapper__link"><?=$answer->user->getFullName()?></a>
            	<?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?>
        	</div>
            <div class="box-wrapper__user margin-b0">
            	<span class="display-ib font__color--crimson margin-t2 margin-b3">HARD CODE</span>
        	</div>
            <div class="box-wrapper__header box-header">
            	<p class="box-header__text height-auto"><?=$answer->text?></p>
            </div>
        </div>
    </div>
    <div class="margin-l40">
        <div class="box-wrapper__footer clearfix">
            <div class="answers-list_item_like-block usefull margin-l0 margin-t5">
            	<div class="answers-list_item_like-block_like"></div>
            	<div class="like_counter">Спасибо<span><?=$answer->votesCount?></span></div>
            </div>
        </div>
    </div>
</div>
**/?>
<?php endif;?>