<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget $this
 * @var \site\frontend\modules\posts\models\Content[] $posts
 */
?>

<div class="b-widget-wrapper b-widget-wrapper_theme">
    <div class="b-widget-header">
        <div class="div b-widget-header__title b-widget-header__title_hot">Горячие темы</div>
    </div>
    <div class="b-widget-content">
        <ul class="b-widget-content__list">
            <?php foreach ($posts as $post): ?>
            <li class="b-widget-content__item">
                <div class="b-widget-content__ava">
                    <a class="ava ava__small ava__<?=$post->user->gender == '1' ? 'male' : 'female'?>" href="<?=$post->user->profileUrl?>">
                        <img class="ava_img" src="<?=$post->user->avatarUrl?>" alt="">
                    </a>
                </div>
                <div class="b-widget-content__title">
                    <a href="<?=$post->url?>" class="link"><?=$post->title?></a>
                </div>
                <div class="b-widget-group-btn">
                    <a href="<?php echo $post->url; ?>" class="b-widget-group-btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></a>
                    <a href="<?php echo $post->url; ?>" class="b-widget-group-btn__users"><?=$post->commentatorsCount?></a>
                    <a href="<?php echo $post->url; ?>#commentsBlock" class="b-widget-group-btn__comment"><?=$post->commentsCount?></a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>