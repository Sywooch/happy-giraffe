<?php
/**
 * @var CommunityContent[] $articles
 */
?><div class="box homepage-articles">

    <div class="title">Интерьер и дизайн <span>- сделаем все красиво!</span></div>

    <ul>
        <li><a href=""><img src="/images/homepage_articles_img.jpg"></a></li>
        <?php foreach ($articles as $article): ?>
            <li><a href="<?=$article->getUrl() ?>"><?=$article->name ?></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="all-link"><a href="">Все статьи (<?=$count ?>)</a></div>

</div>