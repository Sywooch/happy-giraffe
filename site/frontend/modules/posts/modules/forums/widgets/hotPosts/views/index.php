<?php
/**
 * @var \site\frontend\modules\posts\models\Content $posts
 */
?>

<div class="b-hot-themes">
    <div class="title">горячие темы</div>
    <?php foreach ($posts as $post): ?>
    <div class="b-hot-themes_block">
        <div class="b-hot-themes_block_ava"><img src="/images/icons/ava.jpg" alt=""></div>
        <div class="b-hot-themes_block_title"><a href="<?=$post->url?>"><?=$post->title?></a></div>
        <div class="b-hot-themes_block_info">
            <div class="b-users-info">
                <span class="see"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span>
                <span class="people"><?=$post->commentatorsCount?></span>
                <span class="message"><?=$post->commentsCount?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>