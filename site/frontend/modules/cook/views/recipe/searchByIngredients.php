<?php
$basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'recipe' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

$cs = Yii::app()->clientScript;

$cs
    ->registerScriptFile($baseUrl . '/searchByIngredients.js', CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
    ->registerCoreScript('jquery.ui')
    ->registerCssFile($cs->coreScriptUrl . '/jui/css/base/jquery-ui.css')
    ->registerScriptFile('/javascripts/jquery.jscrollpane.min.js')
    ->registerCssFile('/stylesheets/jquery.jscrollpane.css')
;
?>

<div id="cook-recipe-search">
    <?=CHtml::beginForm(array('/cook/recipe/searchResult/', 'section' => $this->section), 'get', array('id' => 'searchRecipeForm'))?>

    <div class="title clear">
        <i class="icon"></i>
        <span>Поиск рецепта</span>
        <div class="nav">
            <ul>
                <li class="active"><?=HHtml::link('По ингредиентам', array('/cook/recipe/searchByIngredients', 'section' => $this->section), array(), true)?></li>
                <li><?=HHtml::link('Расширенный поиск', array('/cook/recipe/advancedSearch', 'section' => $this->section), array(), true)?></li>
            </ul>
        </div>
    </div>

    <div class="clearfix">

        <div class="ingredients">

            <div class="block-title">Ингредиенты</div>

            <p>Добавляйте ингредиенты по одному
                (максимум 3 ингредиента), а в окне справа
                будут выводиться результаты поиска.</p>

                <ul>
                    <?php $this->renderPartial('_ingredient_search'); ?>
                </ul>

            <a href="javascript:void(0)" class="add-btn"><i class="icon"></i><span>Добавить ингредиент</span></a>

        </div>

        <div class="result">

            <div class="arrow"></div>

            <div class="text">

                <img src="/images/cook_recipe_search_fork.gif" /><br/>

                <span>Введите ингредиент слева</span>

            </div>

        </div>

    </div>

    <?=CHtml::endForm()?>
</div>

<script id="ingredientTmpl" type="text/x-jquery-tmpl">
    <?php $this->renderPartial('_ingredient_search'); ?>
</script>