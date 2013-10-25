<?php
/**
 * @var $model ScoreInputContestPrize
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        За четвертое место в конкурсе <br><?=$model->getContestLink() ?>
    </div>
    <div class="career-achievement_congratulation-slogan">Поздравляем! Все впереди!</div>
</div>
<div class="career-achievement_center">
    <img src="/images/contest/contest-career-<?=$model->contest_id ?>.png" alt="">
</div>