<?=Str::strToParagraph($article->preview) ?>
<div class="b-article_in-img">
    <img src="<?= $article->morning->getPhotoUrl(0) ?>" alt="">
</div>
<div class="b-article_in-img">
    <img src="<?= $article->morning->getPhotoUrl(1) ?>" alt="">
</div>
<div class="b-article_in-img">
    <img src="<?= $article->morning->getPhotoUrl(2) ?>" alt="">
</div>
<?php if (count($article->morning->photos) > 3): ?>
    <a href="<?=$article->url ?>" class="more"><i class="icon"></i>еще <?= count($article->morning->photos) - 3 ?> фото</a>
<?php endif ?>
