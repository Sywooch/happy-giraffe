<a href="<?= $user->profileUrl ?>" class="ava ava__female ava__small-xs ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="<?= $user->avatarUrl ?>" class="ava_img"></a><a href="<?= $user->profileUrl ?>" class="b-article_author"><?= $user->fullName ?></a>
<?php if ($user->specInfo !== null): ?>
    <div class="b-article_authorpos"><?=$user->specInfo['title']?></div>
<?php endif; ?>