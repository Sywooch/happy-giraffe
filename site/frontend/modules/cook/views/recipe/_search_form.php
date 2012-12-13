<div class="clearfix">

    <div class="search clearfix">

        <div class="title">

            <div class="links">
                <?=HHtml::link('По ингредиентам', array('/cook/recipe/searchByIngredients', 'section' => $this->section), array(), true)?>
                <?=HHtml::link('Расширеный поиск', array('/cook/recipe/advancedSearch', 'section' => $this->section), array(), true)?>
            </div>

            <i class="icon"></i>
            <span>Поиск рецептов</span>

        </div>

        <?=CHtml::beginForm('/cook/recipe/search', 'get')?>
        <input value="<?php if (isset($_GET['text'])) echo urldecode($_GET['text']) ?>" name="text" type="text" placeholder="Введите ключевое слово в названии рецепта" />
        <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
        <?=CHtml::endForm()?>

    </div>

</div>