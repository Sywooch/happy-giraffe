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
            <div class="img"><img src="/images/icons/ava.jpg" alt=""></div>
            <div class="name"><?=$post->user->fullName?></div>
            <div class="time"><span>5</span>минут назад</div>
            <h3><a href="<?=$post->url?>"><?=$post->title?></a></h3>
            <?php if ($tag = \site\frontend\modules\posts\modules\forums\components\TagHelper::getTag($post)): ?>
                <div class="hashtag">
                    <span><?=$tag?></span>
                </div>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</secton>
