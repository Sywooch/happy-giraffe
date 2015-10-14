<?php

?>

<?php if (($authorView = $post->templateObject->getAttr('authorView', 'default')) == 'default'): ?>
    <a href="<?= $post->user->profileUrl ?>" class="ava ava__female ava__small-xs ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="<?= $post->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $post->user->profileUrl ?>" class="b-article_author"><?= $post->user->fullName ?></a>
    <?= HHtml::timeTag($post, array('class' => 'tx-date'), null); ?>
    <?php if ($post->user->specInfo !== null): ?>
        <div class="b-article_authorpos"><?=$post->user->specInfo['title']?></div>
    <?php endif; ?>
<?php endif; ?>
<?php if ($authorView == 'club' && ($clubData = $post->templateObject->getAttr('clubData'))): ?>
    <?=$clubData['title']?>
<?php endif; ?>