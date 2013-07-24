<?php
/**
 * @var $model ScoreInputContestParticipation
 */
?><div class="career-achievement_left">
    <div class="career-achievement_gray">
        За участие в конкурсе <br><?=$model->getContestLink() ?>
    </div>
    <div class="career-achievement_congratulation-slogan">Вперед, к победе!</div>
</div>
<div class="career-achievement_center">
    <img src="/images/contest/contest-career-<?=$model->contest_id ?>.png" alt="">
</div>