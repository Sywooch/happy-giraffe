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
        <div class="b-froum-theme-img">
            <a class="ava ava__middle ava__<?=$data->user->gender == '1' ? 'male' : 'female'?>" href="<?=$data->user->profileUrl?>">
                <img class="ava_img" src="<?=$data->user->avatarUrl?>" alt="">
            </a>
        </div>
        <div class="b-froum-theme-info">
            <a href="<?=$data->user->profileUrl?>" class="name"><?=$data->user->fullName?></a>
            <?=HHtml::timeTag($data, ['class' => 'time'], null)?>
            <span class="a-mark-wrapper">
                <?php if ($data->isHot): ?><span class="a-mark a-mark_hot"></span><?php endif; ?>
                <?php if ($data->wasHot): ?><span class="a-mark a-mark_default"></span><?php endif; ?>
            </span>
            <a href="<?=$data->url?>" class="b-froum-theme-info-title" style="display:block;"><?=$data->title?></a>
            <p><?=\site\common\helpers\HStr::truncate($data->text, 140)?></p>
            <div class="b-froum-theme-info-more clearfix">
                <?php if ($tag): ?>
                    <div class="hashtag">
                        <a href="<?=$tag['url']?>"><?=$tag['text']?></a>
                    </div>
                <?php endif; ?>
                <div class="c-list_item_btn">
                    <a href="<?php echo $data->url; ?>" class="c-list_item_btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></a>
                    <a href="<?php echo $data->url; ?>" class="c-list_item_btn__users"><?=$data->commentatorsCount?></a>
                    <a href="<?php echo $data->url; ?>#commentsBlock" class="c-list_item_btn__comment"><?=$data->commentsCount?></a>
                </div>
            </div>
        </div>
    </div>
</div>