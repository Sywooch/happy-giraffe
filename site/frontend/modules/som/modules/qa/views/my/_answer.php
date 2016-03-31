<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $data
 */
?>

<a class="popup-widget_cont_heading" href="<?=$data->question->url?>"><?=CHtml::encode($data->question->title)?></a>

<div class="answers-list <?=($data->isBest) ? 'best-answer' : 'all-answers' ?>">
    <div class="answers-list_item">
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
            <?php if ($data->isBest): ?>
                <div class="dialog-arrow dialog-arrow-bestred"></div>
            <?php endif; ?>
            <div class="answers-list_item_text-block_text">
                <?=$data->purified->text?>
            </div>
        </div>
        <div class="answers-list_item_like-block">
            <div class="answers-list_item_like-block_like"></div><span><?=$data->votesCount?><?php if ($data->isBest): ?> Лучший ответ<?php endif; ?></span>
        </div>
    </div>
</div>