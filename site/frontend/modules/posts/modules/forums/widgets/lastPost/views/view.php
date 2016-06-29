<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget $this
 * @var \site\frontend\modules\posts\models\Content[] $posts
 */
?>

<secton class="last-themes-onforum">
    <div class="title">Последние темы на форумах</div>
    <ul class="last-themes-onforum_list">
        <?php foreach ($posts as $post): ?>
        <li>
            <div class="img">
                <a class="ava ava__<?=$post->user->gender == '1' ? 'male' : 'female'?>" href="<?=$post->user->profileUrl?>">
                    <img class="ava_img" src="<?=$post->user->avatarUrl?>" alt="">
                </a>
            </div>
            <div class="name"><?=$post->user->fullName?></div>
            <?=HHtml::timeTag($post, ['class' => 'time'], null)?>
            <h3><a href="<?=$post->url?>"><?=$post->title?></a></h3>
            <?php if ($tag = \site\frontend\modules\posts\modules\forums\components\TagHelper::getTag($post)): ?>
                <div class="hashtag">
                    <a href="<?=$tag['url']?>"><?=$tag['text']?></a>
                </div>
            <?php endif; ?>
            <div class="c-list_item_btn">
                <span class="c-list_item_btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></span>
                <span class="c-list_item_btn__users"><?=$post->commentatorsCount?></span>
                <span class="c-list_item_btn__comment"><?=$post->commentsCount?></span>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</secton>
