<?php
/* @var $this Controller
 * @var $data CookRecipe
 */
?><div class="entry recipe-article clearfix">

    <?php $this->renderPartial('_recipe_parts/_header',array('recipe'=>$data, 'full'=>false)); ?>

    <div class="entry-content">

        <?php $this->renderPartial('_recipe_parts/_cook_book', array('recipe' => $data)); ?>

        <div class="recipe-photo">
            <div class="big">
                <?php if ($data->mainPhoto) echo HHtml::image($data->mainPhoto->getPreviewUrl(460, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'photo'), true)?>
            </div>
        </div>

        <div style="clear:left;"></div>

        <?php $this->renderPartial('_recipe_parts/_recipe_description', array('recipe' => $data)); ?>

        <h2>Приготовление</h2>

        <div class="instructions wysiwyg-content">

            <p><?=Str::truncate(strip_tags($data->text), 400)?> <?=HHtml::link('Весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'), true)?></p>
        </div>

    </div>

</div>