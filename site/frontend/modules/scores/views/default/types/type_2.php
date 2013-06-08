<?php
/**
 * @var $model ScoreInputNewPost
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        <?php if (empty($model->entity)):?>
            За новые записи
        <?php else: ?>
            За новую запись <?=$model->getLink() ?>
        <?php endif ?>
    </div>
    <div class="career-achievement_congratulation-slogan">Обязательно напишите еще!</div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
    <?php if (!empty($model->ids)):?>
        <span class="career-achievement_gray verticalalign-m"><?=count($model->ids).' '.HDate::GenerateNoun(array('запись', 'записи', 'записей'), count($model->ids)) ?></span>
    <?php endif ?>
</div>