<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer
 */
?>
<div class="pediator-answer__left pediator-answer__left--style">
<!-- ava--><span class="ava ava__middle ava__female ava__b-pink"><img alt="" src="<?=$answer->user->avatarUrl?>" class="ava_img"></span>
</div>
<div class="pediator-answer__right_550 margin-b5 pediator-answer__right-active">
    <div class="box-wrapper__user"><a href="<?=$answer->user->profileUrl?>" class="box-wrapper__link"><?=$answer->user->getFullName()?></a>
      <?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?>
    </div>
    <div class="answers-list_item_text-block_text-mod margin-b5"><?=\site\common\helpers\HStr::truncate($answer->text, 150)?></div>
</div>
<div class="answers-list_item_like-block answers-list_item_like-block-active float-n answers-list_item_like-block_mobile"><a href="#" class="answers-list_item_like-block_like"></a>
	<div class="like_counter">Спасибо<span><?=$answer->votesCount?></span></div>
</div>
