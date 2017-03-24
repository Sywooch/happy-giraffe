<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $data
 */
?>

<li class="questions_item clearfix">
    <?php if ($data->user->avatarUrl): ?>
        <div class="questions-modification__avatar awatar-wrapper">
            <a href="<?=$data->user->profileUrl?>" class="awatar-wrapper__link">
                <img src="<?=$data->user->avatarUrl?>" class="awatar-wrapper__img">
            </a>
        </div>
    <?php endif; ?>
    <div class="questions-modification__box questions-modification__box-w98 box-wrapper box-wrapper_mod">
        <div class="box-wrapper__user box-wrapper__user-mod">
            <a href="<?=$data->user->profileUrl?>" class="box-wrapper__link"><?=$data->user->getFullName()?></a>
            <?=HHtml::timeTag($data, ['class' => 'box-wrapper__date'])?>
        </div>
        <div class="box-wrapper__header box-header">
            <p class="box-header__text margin-b9"><?=\site\common\helpers\HStr::truncate($data->text, 150)?></p>
            <a href="<?=$data->question->url?>" class="box-header__link"><?=$data->question->title?></a>
        </div>
        <div class="box-wrapper__footer margin-t10">
            <div class="answers-list_item_like-block answers-list_item_like-block_like-active usefull margin-l0">
                <div class="answers-list_item_like-block_like"></div>
                <div class="like_counter">Спасибо<span><?=$data->votesCount?></span></div>
            </div>
        </div>
    </div>
</li>