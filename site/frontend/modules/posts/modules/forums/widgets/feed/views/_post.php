<?php
/**
 * @var \site\frontend\modules\posts\models\Content $data
 */
?>

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
            <div class="hashtag">
                <a href="#">Общее развитие ребенка</a>
            </div>
            <div class="b-users-info">
                <span class="see"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span>
                <span class="people"><?=$data->commentatorsCount?></span>
                <span class="message"><?=$data->commentsCount?></span>
            </div>
        </div>
    </div>
</div>