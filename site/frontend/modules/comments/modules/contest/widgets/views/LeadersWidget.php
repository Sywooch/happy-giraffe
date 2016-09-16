<?php
use site\frontend\modules\comments\modules\contest\components\ContestHelper;

/**
 * @var \site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant[] $leaders
 * @var int $limit
 * @var int $count
 */
?>

<div class="b-contest__title-blue textalign-c">Сейчас лидируют</div>
<div class="clearfix">
    <div class="b-raiting margin-t30 margin-b30 clearfix">
    <?php for ($i = 0; $i < $this->count;$i++): ?>
        <div class="b-raiting__left float-l">
            <div class="b-raiting-wrapper b-raiting-wrapper_blue clearfix">
                <div class="b-raiting__item float-l">
                    <div class="b-raiting__num b-raiting__num_yellow margin-r15"><?= $i + 1 ?></div><a href="<?= $this->leaders[$i]->user->getUrl() ?>" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="<?= $this->leaders[$i]->user->getUrl() ?>" class="ava ava__female ava__middle-sm"><img alt="" src="<?= $this->leaders[$i]->user->getAvatarUrl() ?>" class="ava_img"></span></a>
                    <div class="contest-footer__ball w-110">
                        <div class="contest-footer__ball-text textalign-l"><?= $this->leaders[$i]->user->getFullName() ?></div>
                    </div>
                </div>
                <div class="b-raiting__item float-r">
                    <div class="contest-footer__ball margin-t10">
                        <div class="contest-footer__ball-num"><?= $this->leaders[$i]->score ?></div>
                        <div class="contest-footer__ball-text"><?= ContestHelper::getWord($this->leaders[$i]->score, ContestHelper::$pointsWords) ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
    </div>
    <?php if (\Yii::app()->user->isGuest): ?>
        <div class="textalign-c"><a href="#" class="btn btn-ml btn-yellow login-button" data-bind="follow: {}">Принять участие</a></div>
    <?php endif; ?>
</div>
