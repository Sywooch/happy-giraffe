<?=Str::strToParagraph($article->preview) ?>
<?php foreach ($article->morning->photos as $photo): ?>
    <div class="b-article_in-img b-article_in-img__l">
        <img src="<?=$photo->url ?>" alt="" class="content-img" />
    </div>
    <?=Str::strToParagraph($photo->text) ?>
<?php endforeach; ?>
