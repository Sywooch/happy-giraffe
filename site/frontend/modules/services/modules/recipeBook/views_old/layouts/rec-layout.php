<?php $this->beginContent('//layouts/main'); ?>
<!--<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Народные рецепты</span></div>-->

<div class="traditional-recipes-title">
    Народные рецепты
</div>


<div class="clearfix">
    <div class="main">
        <div class="main-in">

            <?=$content?>

        </div>
    </div>

    <div class="side-left">

        <div class="club-fast-add">
            <?php if (Yii::app()->user->isGuest):?>
                <?=CHtml::link(CHtml::image('/images/btn_add_recipe.png'), '#login', array('class'=>'fancy', 'data-theme'=>"white-square"))?>
            <?php else: ?>
                <?=CHtml::link(CHtml::image('/images/btn_add_recipe.png'), array('/services/recipeBook/default/form'))?>
            <?php endif ?>
        </div>

        <div class="slide-nav">

            <ul>
                <li class="static"><?=CHtml::link('Все рецепты<i class="icon"></i>', array('/services/recipeBook/default/index'))?></li>
                <?php foreach ($this->nav as $category): ?>
                <li<?php if (array_key_exists($this->disease_id, $category->diseases)): ?> class="toggled"<?php endif; ?>>
                    <a href="javascript:void(0);" onclick="slideNavToggle(this);"><?=$category->title?><i class="icon"></i></a>
                    <ul<?php if (array_key_exists($this->disease_id, $category->diseases)): ?> style="display: block;"<?php endif; ?>>
                        <?php foreach ($category->diseases as $d): ?>
                        <li<?php if ($this->disease_id == $d->id): ?> class="active"<?php endif; ?>><?=CHtml::link($d->title, array('/services/recipeBook/default/index', 'slug' => $d->slug))?><span class="count"><?=$d->recipesCount?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>

    </div>
</div>
<?php $this->endContent(); ?>