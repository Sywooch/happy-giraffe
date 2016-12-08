<?php
use site\frontend\modules\som\modules\qa\models\QaCategory;

/**
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer $data
 */
?>

<li class="answers-list_item">
    <a href="<?= $data->user->profileUrl ?>"
       class="ava ava__middle ava__<?= ($data->user->gender) ? 'male' : 'female' ?>">
        <?php if ($data->user->isOnline): ?>
            <span class="ico-status ico-status__online"></span>
        <?php endif; ?>
        <?php if ($data->user->avatarUrl): ?>
            <img alt="" src="<?= $data->user->avatarUrl ?>" class="ava_img">
        <?php endif; ?>
    </a>
    <div class="username">
        <a href="<?= $data->user->profileUrl ?>"><?= $data->user->fullName ?></a>
        <?= HHtml::timeTag($data, ['class' => 'tx-date']); ?>
    </div>
    <div class="answers-list_item_text-block"
         <?php if ($data->user->specialistInfo['title']): ?>style="background-color: #feebf6; border-radius: 7px;"<?php endif; ?>>
        <?php if (false && $data->isBest): ?>
            <div class="dialog-arrow dialog-arrow-bestred"></div>
        <?php endif; ?>
        <div class="answers-list_item_text-block_text">
            <?= $data->purified->text ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="answers-list_item_like-block login-button" data-bind="follow: {}">
        <div class="answers-list_item_like-block_like"></div>
        <span><?= $data->question->category->isPediatrician() ? 'Спасибо' : 'Полезный ответ' ?> <?= $data->votesCount ?></span>
        <div class="clearfix"></div>
    </div>
</li>