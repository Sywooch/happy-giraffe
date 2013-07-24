<?php
/**
 * @var $model ScoreInputNewVideo
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        <?php if (empty($model->entity)):?>
            За размещение видео
        <?php else: ?>
            За размещение видео <?=$model->getLink() ?>
        <?php endif ?>
    </div>
    <div class="career-achievement_congratulation-slogan">Ждем от вас больше видео!</div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
    <?php if (!empty($model->ids)):?>
        <span class="career-achievement_gray verticalalign-m"><?=count($model->ids)?> видео</span>
    <?php endif ?>
</div>