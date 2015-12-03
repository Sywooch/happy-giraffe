<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaUserRating $model
 */
?>

<li class="rating-widget_users-list_item">
    <div class="rating-widget_users-list_item_cont">
        <a href="<?=$model->user->profileUrl?>" class="ava ava__middle ava__<?=($model->user->gender) ? 'male' : 'female'?>">
            <?php if ($model->user->avatarUrl): ?>
                <img alt="" src="<?=$model->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <a href="<?=$model->user->profileUrl?>"><?=$model->user->fullName?></a>
        <div class="questions-counters"><span>Вопросов <?=$model->questionsCount?></span><span>Ответов <?=$model->answersCount?></span></div>
    </div>
    <div class="users-rating <?=\site\frontend\modules\som\modules\qa\components\QaHelper::getRatingClass($model->position)?>">
        <div class="users-rating_crown"></div>
        <div class="users-rating_counter"><?=round($model->rating)?></div>
    </div>
    <div class="clearfix"></div>
</li>