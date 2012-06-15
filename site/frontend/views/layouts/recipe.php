<?php $this->beginContent('//layouts/main'); ?>

<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Приправы и специи</span></div>

<div id="cook-recipe">

    <div class="clearfix">

        <div class="add-recipe">

            Поделиться вкусненьким!<br/>
            <a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/cook/recipe/add')?>" class="btn btn-green<?php if (Yii::app()->user->isGuest): ?> fancy<?php endif; ?>"><span><span>Добавить рецепт</span></span></a>

        </div>

        <div class="search clearfix">

            <div class="title">

                <div class="links">
                    <?=CHtml::link('По ингредиентам', '/cook/recipe/searchByIngredients')?>
                    <?=CHtml::link('Расширеный поиск', '/cook/recipe/advancedSearch')?>
                </div>

                <i class="icon"></i>
                <span>Поиск рецептов</span>

            </div>

            <?=CHtml::beginForm('/cook/recipe/search', 'get')?>
                <input name="text" type="text" placeholder="Введите ключевое слово в названии рецепта" />
                <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
            <?=CHtml::endForm()?>

        </div>

    </div>

    <div class="clearfix">

        <div class="main">

            <div class="main-in">

                <?=$content?>

            </div>

        </div>

        <div class="side-left">

            <div class="recipe-categories">
                <ul>
                    <li<?php if ($this->currentType == null): ?> class="active"<?php endif; ?>>
                        <a href="<?=$this->createUrl('/cook/recipe')?>" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-0"></i>
                            <span>Все рецепты</span>

                        </a>
                        <span class="count"><?=$this->counts[0]?></span>
                    </li>
                    <?php foreach (CookRecipe::model()->types as $id => $label): ?>
                        <li<?php if ($this->currentType == $id): ?> class="active"<?php endif; ?>>
                            <a href="<?=$this->createUrl('/cook/recipe/index', array('type' => $id))?>" class="cook-cat">
                                <i class="icon-cook-cat icon-recipe-<?=$id?>"></i>
                                <span><?=$label?></span>
                            </a>
                            <span class="count"><?=$this->counts[$id]?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>

        </div>

    </div>

</div>

<?php $this->endContent(); ?>