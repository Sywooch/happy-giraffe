<?php
/**
 * @var $model ScoreInputNewPhoto
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        За добавленные фото
    </div>
    <div class="career-achievement_congratulation-slogan">Фотографируйтесь чаще!</div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
    <span class="career-achievement_gray verticalalign-m"><?=count($model->ids).' фото' ?></span>
</div>