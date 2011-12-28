<?php
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
?>

<div class="left-inner">

    <div class="add">
        <a class="btn-green_bl" href="<?php echo $this->createUrl('/recipeBook/default/create') ?>">Добавить<br> рецепт</a>
    </div>

    <div class="themes">
        <div class="theme-pic_double">Инфекционные<br>заболевания</div>
        <ul class="leftlist">
            <?php foreach ($cat as $cat_disease): ?>
            <li><a <?php if ($cat_disease->id == $model->id) echo 'class="current" ' ?>
                href="<?php echo $this->createUrl('/recipeBook/default/view', array('url' => $cat_disease->slug)) ?>"><?php
                echo $cat_disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>


    </div>

    <div class="leftbanner">
        <a href="/"><img src="/images/leftban.png"></a>
    </div>

</div>

<div class="right-inner">

    <?php $this->renderPartial('disease_data',array(
        'recipes' => $recipes,
        'pages' => $pages
    )); ?>

<div class="clear"></div><!-- .clear -->

</div>