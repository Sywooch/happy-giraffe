<?php
    $basePath = Yii::getPathOfAlias('recipeBook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile($baseUrl . '/form.js', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
        ->registerCoreScript('jquery.ui')
        ->registerCssFile($cs->coreScriptUrl . '/jui/css/base/jquery-ui.css');
    ;
?>

<div class="main">

    <div class="main-right">

        <div id="cook-add-recipe" class="traditional">

            <?php $form = $this->beginWidget('CActiveForm', array('id' => 'addRecipeForm')); ?>

                <div class="form-in">

                    <div class="title"><i class="icon"></i><?=$recipe->isNewRecord ? 'Добавить' : 'Редактировать'?> народный рецепт</div>

                    <?=$form->errorSummary(CMap::mergeArray($recipe->ingredients, array($recipe)))?>

                    <div class="row">

                        <div class="recipe-name">

                            <?=$form->label($recipe, 'title', array('class' => 'row-title'))?><br/>

                            <?=$form->textField($recipe, 'title')?>

                        </div>

                    </div>

                    <div class="row">

                        <div class="product-list">

                            <label class="row-title">Ингредиенты</label>

                            <table>
                                <?php foreach ($ingredients as $k => $i): ?>
                                    <?php $this->renderPartial('_ingredient', array('n' => $k, 'form' => $form, 'model' => $i, 'units' => $units,'canHideRemoveLink'=>true)); ?>
                                <?php endforeach; ?>

                            </table>

                            <a href="javascript:void(0)" class="add-btn"><i class="icon"></i><span>Добавить ингредиент</span></a>

                        </div>

                    </div>

                    <div class="row">

                        <?=$form->label($recipe, 'text', array('class' => 'row-title'))?><br/>

                        <?php
                            $this->widget('ext.ckeditor.CKEditorWidget', array(
                                'model' => $recipe,
                                'attribute' => 'text',
                                'config' => array(
                                    'toolbar' => 'Simple',
                                    'width' => 620,
                                    'height' => 157,
                                ),
                            ));
                        ?>

                    </div>

                    <div class="row clearfix">

                        <div class="col">

                            <?=$form->label($recipe, 'category_id', array('class' => 'row-title'))?><br/>
										
										<span class="chzn-v2">
											<?=CHtml::dropDownList('category_id', (isset($recipe->disease) ? $recipe->disease->category_id:''), CHtml::listData($diseaseCategories, 'id', 'title'), array('class' => 'chzn', 'prompt' => 'не выбран'))?>
										</span>

                        </div>

                        <div class="col">

                            <?=$form->label($recipe, 'disease_id', array('class' => 'row-title'))?><br/>
										
										<span class="chzn-v2">
											<?=$form->dropDownList($recipe, 'disease_id', (isset($recipe->disease) ? CHtml::listData($recipe->disease->category->diseases, 'id', 'title') : array()), array('class' => 'chzn', 'prompt' => 'не выбрана'))?>
										</span>

                        </div>

                    </div>

                </div>

                <div class="row-btn">

                    <!--<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>-->
                    <!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
                    <button class="btn btn-green-medium"><span><span><?=$recipe->isNewRecord ? 'Добавить' : 'Редактировать'?></span></span></button>

                </div>

            <?php $this->endWidget(); ?>

        </div>

    </div>

</div>

<div class="side-right">

</div>

<script id="ingredientTmpl" type="text/x-jquery-tmpl">
    <?php $this->renderPartial('_ingredient', array(
        'n' => '${n}',
        'form' => $form,
        'model' => RecipeBookRecipeIngredient::model()->emptyModel,
        'units' => $units,
        'canHideRemoveLink'=>false
    )); ?>
</script>