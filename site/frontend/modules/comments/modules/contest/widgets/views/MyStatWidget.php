<?php
use site\frontend\modules\comments\modules\contest\components\ContestHelper;

/**
 * @var \site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant
 */
?>

<div class="contest-footer">
    <div class="contest-footer__flex">
        <div class="contest-footer__box"><a href="<?= $this->participant->user->getUrl() ?>" class="contest-commentator-rating_user-a">
                <!-- ava--><span href="<?= $this->participant->user->getUrl() ?>" class="ava ava__female ava__middle-sm"><img alt="" src="<?= $this->participant->user->getAvatarUrl() ?>" class="ava_img"></span></a>
            <div class="contest-footer__ball">
                <div class="contest-footer__ball-num"><?= $this->participant->score ?></div>
                <div class="contest-footer__ball-text"><?= ContestHelper::getWord($this->participant->score, ContestHelper::$pointsWords)?></div>
            </div>
        </div>
        <div class="contest-footer__box"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/quests'); ?>" class="btn btn-s yellow-btn">Получить задание</a></div>
    </div>
</div>
