<?php
/**
 * @var CookRecipe $recipe
 */
$tags = $recipe->getNotEmptyTags();
if (!empty($tags)) {
    ?>
<div class="cook-article-tags">
    <div class="cook-article-tags-title">Теги</div>
    <ul class="cook-article-tags-list">
        <?php foreach ($tags as $tag): ?><?php
        if (isset($full) && $full && CookRecipeTag::TAG_VALENTINE == $tag->id) $this->body_class .= ' body__valentine'; ?>
            <li><a href="<?=$tag->getUrl() ?>"><?=strip_tags($tag->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php }