<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget $this
 * @var \site\frontend\modules\posts\models\Content[] $posts
 */
?>

<div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
    <div class="b-widget-header"><a href="#" class="b-widget-header__btn">Все</a>
        <div class="div b-widget-header__title b-widget-header__title_hot">Горячие темы</div>
    </div>
    <div class="b-widget-content">
        <ul class="b-widget-content__list">
            <?php foreach ($posts as $post): ?>
            <li class="b-widget-content__item">
                <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                <div class="b-widget-content__title">
                    <a href="<?=$post->url?>" class="link"><?=$post->title?></a>
                </div>
                <div class="b-widget-group-btn">
                    <span class="b-widget-group-btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></span>
                    <span class="b-widget-group-btn__users"><?=$post->commentatorsCount?></span>
                    <span class="b-widget-group-btn__comment"><?=$post->commentsCount?></span>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>