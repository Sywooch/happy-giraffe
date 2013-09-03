<?php
/**
 * @var $model ScoreInputAward
 */
$description = $model->getDescription();
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        <?=$description[0] ?>
    </div>
    <div class="career-achievement_congratulation-slogan"><?=$description[1] ?></div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement_scores-ico">
        <?=$model->getImage() ?>
    </div>
</div>