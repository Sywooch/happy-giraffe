<?php
/**
 * @var CookRecipe $recipe
 */

if (!empty($recipe->tags)) {
    ?>
<div class="cook-article-tags">
    <div class="cook-article-tags-title">Теги</div>
    <ul class="cook-article-tags-list">
        <?php foreach ($recipe->tags as $tag): ?>
            <li><a href="<?=$tag->getUrl() ?>"><?=$tag->title ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php }