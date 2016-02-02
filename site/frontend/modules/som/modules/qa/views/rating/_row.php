<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaUserRating $data
 * @var LiteListView $widget
 */
?>

<li class="faq-rating_item">
    <a href="<?=$data->user->profileUrl?>" class="ava ava ava__female">
        <?php if ($data->user->isOnline): ?>
            <span class="ico-status ico-status__online"></span>
        <?php endif; ?>
        <?php if ($data->user->avatarUrl): ?>
            <img alt="" src="<?=$data->user->avatarUrl?>" class="ava_img">
        <?php endif; ?>
    </a>
    <a class="faq-rating_item_link"><?=$data->user->fullName?></a>
    <div class="faq-rating_item_counters"><span>Вопросов <?=$data->questionsCount?></span><span>Ответов <?=$data->answersCount?></span></div>
    <div class="users-rating <?=\site\frontend\modules\som\modules\qa\components\QaHelper::getRatingClass($data->position)?>">
        <div class="users-rating_crown-big"></div>
        <div class="users-rating_counter"><?=round($data->rating)?></div>
    </div>
    <div class="clearfix"></div>
</li>