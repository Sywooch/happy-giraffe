<?php
/**
 * Author: alexk984
 * Date: 14.06.12
 * @var CookRecipe $recipe
 */
?>

<li class="recipe">
    <div class="item-title"><a href=""><?=$recipe->title ?></a></div>
    <div class="user clearfix">
        <?php $this->widget('Avatar', array('user' => $recipe->author, 'size' => Avatar::SIZE_MICRO)); ?>
    </div>
    <div class="content">
        <?php if ($recipe->photo): ?>
        <img src="<?=$recipe->photo->getPreviewUrl(243, 243, false, true, AlbumPhoto::CROP_SIDE_TOP) ?>" title="<?=$recipe->title ?>"/>
        <?php endif; ?>

        <p>
            <b>Ингредиенты для &laquo;<?=$recipe->title ?>&raquo;</b>
            <?php foreach ($recipe->ingredients as $i): ?>
            <?= $i->ingredient->title ?>
            <?= round($i->value, 2) ?>
            <?= Str::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value) ?>
            <br/>
            <?php endforeach; ?>

        </p>
    </div>
</li>