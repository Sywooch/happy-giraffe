<?php
/**
 * @var CommunityContent[] $articles
 */
?>
<ul>
    <li><a href=""><img src="/images/<?=$image ?>"></a></li>
    <?php foreach ($articles as $article): ?>
    <li><a href="<?=$article->getUrl() ?>"><?=$article->name ?></a></li>
    <?php endforeach; ?>
</ul>

<div class="all-link"><a href="">Все <?=$title ?> (<?=$count ?>)</a></div>