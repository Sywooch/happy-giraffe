<?=Str::strToParagraph($article->preview) ?>

<?php foreach ($article->morning->photos as $photo): ?>
<p><img src="<?=$photo->url ?>" alt=""></p>
<?=Str::strToParagraph($photo->text) ?>
<br>
<?php endforeach; ?>
        