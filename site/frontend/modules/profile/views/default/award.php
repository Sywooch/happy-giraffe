<?php
/**
 * @var ScoreUserAchievement|ScoreUserAward $next
 * @var ScoreUserAchievement|ScoreUserAward $prev
 * @var ScoreUserAchievement|ScoreUserAward $award
 * @var User[] $users
 * @var int $count
 */
?><div class="nav-article margin-b15 margin-t15 clearfix">
    <?php if ($prev !== null):?>
        <div class="nav-article_left">
            <a class="nav-article_arrow nav-article_arrow__left" href=""></a>
            <div class="nav-article_hold">
                <div class="display-ib verticalalign-m margin-r5">
                    <a href="<?=$prev->getUrl() ?>" class="award-ico"><img src="<?=$prev->getAward()->getIconUrl(46)?>" alt=""></a>
                </div>
                <div class="display-ib verticalalign-m">
                    <div class="clearfix">Предыдущая награда</div>
                    <a href="<?=$prev->getUrl() ?>"><?=$prev->getAward()->title ?></a>
                    <div class="font-smallest color-gray clearfix"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($prev->created)) ?></div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <?php if ($next !== null):?>
        <div class="nav-article_right">
            <a class="nav-article_arrow nav-article_arrow__right" href="<?=$next->getUrl() ?>"></a>
            <div class="nav-article_hold">
                <div class="display-ib verticalalign-m">
                    <div class="clearfix">Следующая награда</div>
                    <a href="<?=$next->getUrl() ?>"><?=$next->getAward()->title ?></a>
                    <div class="font-smallest color-gray clearfix"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($next->created)) ?></div>
                </div>
                <div class="display-ib verticalalign-m margin-l5">
                    <a href="<?=$next->getUrl() ?>" class="award-ico"><img src="<?=$next->getAward()->getIconUrl(46)?>" alt=""></a>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<div class="b-award">
    <div class="clearfix">
        <a href="<?=Yii::app()->createUrl('/profile/default/awards', array('user_id'=>$this->user->id)) ?>" class="b-award_back">Вернуться к наградам</a>
    </div>
    <div class="clearfix">
        <div class="b-award_left">
            <div class="b-award_img-hold">
                <span class="award-ico">
                    <img src="<?=$award->getAward()->getIconUrl(200)?>" alt="" class="b-award_img">
                </span>
            </div>
            <div class="b-award_count">+ <?=$award->getAward()->scores ?></div>
        </div>
        <div class="b-award_hold">
            <div class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($award->created)) ?></div>
            <h1 class="b-award_t"><?=$award->getAward()->title ?></h1>
            <div class="b-award_tx"><?=$award->getAward()->description ?></div>
            <div class="ava-small-list clearfix">
                <div class="ava-small-list_t-small">Такое достижение еще у:</div>
                <ul>
                    <?php foreach ($users as $user): ?>
                        <li class="ava-small-list_li">
                            <?php $this->widget('UserAvatarWidget', array('user' => $user, 'size' => 24)) ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($count > count($users)):?>
                        <li class="ava-small-list_li margin-t5"><span class="color-gray">и еще <?=($count - 33) ?></span></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>