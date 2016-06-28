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
            <?=HHtml::timeTag($post, ['class' => 'time'], null)?>
            <h3><a href="<?=$post->url?>"><?=$post->title?></a></h3>
            <?php if ($tag = \site\frontend\modules\posts\modules\forums\components\TagHelper::getTag($post)): ?>
                <div class="hashtag">
                    <a href="<?=$tag['url']?>"><?=$tag['text']?></a>
                </div>
                <div class="c-list_item_btn" style="display:block"><span class="c-list_item_btn__view">589</span><span class="c-list_item_btn__users">6</span><span class="c-list_item_btn__comment">28</span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</secton>
