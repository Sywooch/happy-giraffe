<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget $this
 * @var \site\frontend\modules\posts\models\Content $data
 */
$tag = \site\frontend\modules\posts\modules\forums\components\TagHelper::getTag($data);
if ($data->isHot) {
    $class = 'hot-theme';
} else {
    $class = 'default-theme';
}
?>

<div class="<?=$class?>">
    <div class="b-froum-theme">
        <div class="b-froum-theme-img"><img src="/images/icons/ava.jpg" alt=""></div>
        <div class="b-froum-theme-info">
            <a href="<?=$data->user->profileUrl?>" class="name"><?=$data->title?></a>
            <?=HHtml::timeTag($data, ['class' => 'time'], null)?>
            <span class="a-mark-wrapper">
                <?php if ($data->isHot): ?><span class="a-mark a-mark_hot"></span><?php endif; ?>
            </span>
            <a href="<?=$data->url?>" class="b-froum-theme-info-title" style="display:block;"><?=$data->title?></a>
            <p><?=\site\common\helpers\HStr::truncate($data->text)?></p>
            <div class="b-froum-theme-info-more clearfix">
                <?php if ($tag): ?>
                    <div class="hashtag">
                        <span><?=$tag?></span>
                    </div>
                <?php endif; ?>
                <div class="c-list_item_btn">
                    <span class="c-list_item_btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></span>
                    <span class="c-list_item_btn__users"><?=$data->commentatorsCount?></span>
                    <span class="c-list_item_btn__comment"><?=$data->commentsCount?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (false): ?>
<div class="b-froum-theme top-theme">
    <div class="b-froum-theme-img">
        <?php if ($data->user->avatarUrl): ?>
            <img src="<?=$data->user->avatarUrl?>" alt="">
        <?php endif; ?>
    </div>
    <div class="b-froum-theme-info">
        <a class="name" href="<?=$data->user->profileUrl?>"><?=$data->user->fullName?></a>
        <?=HHtml::timeTag($data, ['class' => 'time'], null)?>
        <img src="/images/icons/attach.png" alt="">
        <a class="b-froum-theme-info-title" href="<?=$data->url?>"><?=$data->title?></a>
        <p><?=\site\common\helpers\HStr::truncate($data->text)?></p>
        <div class="b-froum-theme-info-more">
            <?php if ($tag): ?>
                <div class="hashtag">
                    <a href="#"><?=$tag['text']?></a>
                </div>
            <?php endif; ?>
            <div class="b-users-info">
                <span class="see"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></span>
                <span class="people"><?=$data->commentatorsCount?></span>
                <span class="message"><?=$data->commentsCount?></span>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>