<?php
/**
 * @var $model ScoreInputNewPost
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        За ваши комментарии
    </div>
    <div class="career-achievement_congratulation-slogan">Будьте активны!</div>
</div>
<div class="career-achievement_center">
    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
    <span class="career-achievement_gray verticalalign-m"><?=count($model->ids).' '.HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), count($model->ids)) ?></span>
</div>