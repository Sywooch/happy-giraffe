<?php
/**
 * @var RecipeBookRecipe $data
 * @var bool $showDisease
 */
?>

<li class="traditional-recipes_li">
    <div class="traditional-recipes_author">
        <?php $this->widget('Avatar', array('user' => $data->author, 'size' => Avatar::SIZE_MICRO, 'htmlOptions' => array('class' => 'visible-md-inline-block'))); ?>
        <a href="<?=$data->author->getUrl()?>" class="a-light"><?=$data->author->getFullName()?></a>
    </div>
    <div class="traditional-recipes_t"><a href="<?=$data->getUrl()?>" class="traditional-recipes_t-a"><?=$data->title?></a></div>
    <?php if ($showDisease): ?>
        <div class="b-tags"><a href="<?=$data->disease->getUrl()?>" class="b-tags_tag"><?=$data->disease->title?></a></div>
    <?php endif; ?>
</li>