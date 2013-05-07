<?php
/*
 * @var $recipe CookRecipe
 */
?>

<div class="entry">
    <?php $this->renderPartial('/_section', array('data' => $recipe)); ?>
    <?php $this->renderPartial('/_entry_header', array('data' => $recipe, 'full' => true)); ?>
    <div class="entry-content recipe-article clearfix">
        <div class="recipe-photo">

            <?php if ($recipe->mainPhoto !== null): ?>
                <div class="recipe-photo_hold">
                    <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(460, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'recipe-photo'))?>
                </div>
            <?php endif; ?>

            <div class="recipe-photo-list clearfix">

                <ul class="recipe-photo-list_ul">
                    <?php foreach ($recipe->thumbs as $t): ?>
                        <li class="recipe-photo-list_li">
                            <a href="" class="recipe-photo-list_i"><?=CHtml::image($t->photo->getPreviewUrl(60, 40, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_CENTER), $t->photo->title)?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
        <?php if ($recipe->cuisine || $recipe->preparation_duration || $recipe->cooking_duration || $recipe->servings): ?>
            <div class="recipe-info">
                <?php if ($recipe->cuisine): ?>
                    <div class="recipe-info_i clearfix">
                                <span class="recipe-info_country ">
                                    <?php if (!empty($recipe->cuisine->country_id)): ?>
                                        <span class="recipe-info_ico">
                                            <div class="flag-big flag-big-<?=$recipe->cuisine->country->iso_code?>"></div>
                                        </span>
                                    <?php endif; ?>
                                    <div class="recipe-info_hold">
                                        <span class="recipe-info_country-name"><?=$recipe->cuisine->title?></span>
                                    </div>
                                </span>
                    </div>
                <?php endif; ?>
                <?php if ($recipe->preparation_duration): ?>
                    <div class="recipe-info_i clearfix">
                        <div class="recipe-info_ico recipe-info_ico__time-1"></div>
                        <div class="recipe-info_hold">
                            <div class="recipe-info_desc">подготовка</div>
                            <div class="recipe-info_value"><?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($recipe->cooking_duration): ?>
                    <div class="recipe-info_i clearfix">
                        <div class="recipe-info_ico  recipe-info_ico__yield"></div>
                        <div class="recipe-info_hold">
                            <div class="recipe-info_desc">приготовление</div>
                            <div class="recipe-info_value"><?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($recipe->servings): ?>
                <div class="recipe-info_i clearfix">
                    <div class="recipe-info_ico  recipe-info_ico__time-2"></div>
                    <div class="recipe-info_hold">
                        <div class="recipe-info_desc">кол-во порций</div>
                        <div class="recipe-info_value">на <?=$recipe->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($recipe->ingredients): ?>
            <h2 class="recipe-article_h2">Ингредиенты</h2>
            <ul class="ingredient">
                <?php foreach ($recipe->ingredients as $i): ?>
                    <li class="ingredient_i">
                        <span class="ingredient_name"><?=$i->ingredient->title?></span>
                        - <span class="ingredient_amount">
                            <?php if ($i->unit->type != 'undefined'): ?><?=$i->display_value?>&nbsp;<?php endif; ?><?=$i->noun?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h2 class="recipe-article_h2">Приготовление</h2>

        <div class="wysiwyg-content">
            <?=$recipe->purified->text?>
        </div>

        <?php if ($recipe->section == 0 && $tags = $recipe->getNotEmptyTags()): ?>
            <div class="tags clearfix">
                <div class="tags_t">Теги:</div>
                <ul class="tags-ul">
                    <?php foreach ($tags as $tag): ?>
                        <li class="tags_li"><?=CHtml::link($tag->title, $tag->url)?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>

</div>

<?php if (! empty($next)): ?>
    <div class="margin-10 textalign-c clearfix">
        <a href="<?=$next[0]->url?>" class="btn-green btn-medium">Следующий <i class="ico-arrow ico-arrow__right"></i></a>
    </div>

    <div class="interesting">
        <div class="interesting_t">Еще вкусненькое</div>
        <ul>
            <?php foreach ($next as $n): ?>
                <li class="interesting_i clearfix">
                    <a href="<?=$n->url?>">
                        <?php if ($n->mainPhoto): ?>
                            <span class="interesting_img"><?=CHtml::image($n->mainPhoto->getPreviewUrl(47, 42, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_CENTER), $n->title)?></span>
                        <?php endif; ?>
                        <?=$n->title?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>