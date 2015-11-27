<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer $data
 */
?>

<li class="answers-list_item">
    <a href="<?=$data->user->profileUrl?>" class="ava ava__middle ava__<?=($data->user->gender) ? 'male' : 'female'?>">
        <?php if ($data->user->isOnline): ?>
            <span class="ico-status ico-status__online"></span>
        <?php endif; ?>
        <?php if ($data->user->avatarUrl): ?>
            <img alt="" src="<?=$data->user->avatarUrl?>" class="ava_img">
        <?php endif; ?>
    </a>
    <div class="username">
        <a href="<?=$data->user->profileUrl?>"><?=$data->user->fullName?></a>
        <?= HHtml::timeTag($data, array('class' => 'tx-date')); ?>
    </div>
    <div class="answers-list_item_text-block">
        <div class="dialog-arrow dialog-arrow-bestred"></div>
        <div class="answers-list_item_text-block_text">
            <?=$data->text?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="answers-list_item_like-block">
        <div class="answers-list_item_like-block_like"></div><span>Полезный ответ <?=$data->votesCount?></span>
        <div class="clearfix"></div>
    </div>
</li>