<?=Str::strToParagraph($article->preview) ?>
<div class="big"><img src="<?= $article->morning->getPhotoUrl(0) ?>"></div>
<div class="thumbs">
    <ul>
        <li><img src="<?= $article->morning->getPhotoUrl(1) ?>"></li>
        <li><img src="<?= $article->morning->getPhotoUrl(2) ?>"></li>
        <?php if (count($article->morning->photos) > 3): ?>
        <li><a href="<?=$article->url ?>" class="more"><i
            class="icon"></i>еще <?= count($article->morning->photos) - 3 ?> фото</a></li>
        <?php endif ?>
    </ul>
</div>
