<?php
/**
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContest[] $contests
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant[] $winners
 * @var int $contestId
 */

use site\frontend\modules\comments\modules\contest\components\ContestHelper;
use site\frontend\modules\comments\modules\contest\components\ContestManager;

$this->pageTitle = 'Победители';
?>
<div class="b-contest__block b-contest-winner textalign-c">
    <div class="b-contest__title">Победители</div>
    <div class="b-contest-winner__menu">
        <ul class="textalign-c">
            <?php foreach ($contests as $contest): ?>
            <li class="contest-header__li">
                <a href="<?= \Yii::app()->createUrl('/comments/contest/default/winners', array('contestId' => $contest->id)); ?>" class="b-contest-winner__link <?= $contestId == $contest->id ? 'b-contest-winner__link-active' : '' ?>"><?= $contest->getFullMonth() ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
        <?php if (\Yii::app()->user->isGuest && $contestId == $this->contest->id): ?>
            <div class="b-contest-winner__container b-contest-winner__container-konvers margin-b40">
        <?php else: ?>
            <div class="b-contest-winner__container margin-b40">
        <?php endif; ?>
            <?php $count = count ($winners); ?>
            <?php for ($i = 0; $i < $count; $i++): ?>
            <div class="b-contest-winner__item">
                <div class="b-raiting-wrapper b-raiting-wrapper_transparent clearfix">
                    <div class="b-raiting__item float-l">
                        <div class="b-raiting__num b-raiting__num_yellow margin-r15"><?= $i + 1 ?></div><a href="<?= $winners[$i]->user->getUrl() ?>" class="contest-commentator-rating_user-a">
                            <!-- ava--><span href="<?= $winners[$i]->user->getUrl() ?>" class="ava ava__female"><img alt="" src="<?= $winners[$i]->user->getAvatarUrl() ?>" class="ava_img"></span></a>
                        <div class="contest-footer__ball w-110 textalign-l">
                            <a href="<?= $winners[$i]->user->getUrl() ?>" class="contest-footer__ball-text contest-footer__ball-text_blue textalign-l"><?= $winners[$i]->user->getFullName() ?></a>
                        </div>
                    </div>
                    <div class="b-raiting__item float-l">
                        <div class="b-contest-winner__box float-l">
                            <?php if ($contestId != ContestManager::getCurrentActive()->id && $winners[$i]->score >= 500 && $winners[$i]->user->getAvatarUrl()): ?>
                            <div class="b-contest-winner__box-ico"></div>
                            <div class="b-contest-winner__box-text">Денежный приз<br>1000 рублей</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="b-raiting__item float-r">
                        <div class="contest-footer__ball contest-footer__ball_black margin-t10">
                            <div class="contest-footer__ball-num"><?= $winners[$i]->score ?></div>
                            <div class="contest-footer__ball-text"><?= ContestHelper::getWord($winners[$i]->score, ContestHelper::$pointsWords)?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
            <?php if (\Yii::app()->user->isGuest && $contestId != $this->contest->id):?>
                <div class="textalign-c margin-t20" ><a href="#" class="btn btn-forum green-btn login-button" data-bind="follow: {}">Принять участие</a></div>
            <?php endif; ?>
        <?php if (\Yii::app()->user->isGuest && $contestId == $this->contest->id): ?>
            <div class="b-contest-winner__contain textalign-c">
                <div class="b-contest-winner__center">
                    <div class="b-contest-winner__contain-ico"></div>
                    <div class="b-contest-winner__contain-title">В этом месяце идет серьезная борьба, попробуй поучаствуй!</div>
                    <a href="#" class="btn btn-forum green-btn login-button" data-bind="follow: {}">Принять участие</a>
                </div>
            </div>
        <?php endif; ?>
</div>
