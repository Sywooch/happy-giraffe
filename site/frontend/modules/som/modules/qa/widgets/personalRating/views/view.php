<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaUserRating $model
 */
?>

<div class="faq-rating">
    <div class="faq-rating_item">
        <a href="<?=$model->user->profileUrl?>" class="ava ava ava__<?=($model->user->gender) ? 'male' : 'female'?>">
            <?php if ($model->user->avatarUrl): ?>
                <img alt="" src="<?=$model->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <a class="faq-rating_item_link" href="<?=$model->user->profileUrl?>"><?=$model->user->getFullName()?></a>
        <div class="faq-rating_item_counters">
            <span>Вопросов <?=$model->questionsCount?></span>
            <span>Ответов <?=$model->answersCount?></span>
        </div>
        <div class="users-rating <?=\site\frontend\modules\som\modules\qa\components\QaHelper::getRatingClass($model->position)?>">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter"><?=round($model->rating)?></div>
        </div>
    </div><a class="faq-rating_all" href="<?=Yii::app()->controller->createUrl('/som/qa/rating/index')?>">Общий рейтинг</a>
</div>