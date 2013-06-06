<?php
/**
 * @var $model ScoreInputNewFriend
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        За новую дружбу на сайте
    </div>
    <div class="career-achievement_congratulation-slogan">Находите новых друзей!</div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
    <span class="career-achievement_gray verticalalign-m"><?=count($model->ids).' '.HDate::GenerateNoun(array('друг', 'друга', 'друзей'), count($model->ids)) ?></span>
</div>