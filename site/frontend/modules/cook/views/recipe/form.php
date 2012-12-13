<?php
    $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'recipe' . DIRECTORY_SEPARATOR . 'assets';
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

        <div id="cook-add-recipe">

        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'addRecipeForm')); ?>

                <div class="form-in">

                    <div class="title"><i class="icon"></i><?=$recipe->isNewRecord ? 'Добавить' : 'Редактировать'?></div>

                    <?=$form->errorSummary(CMap::mergeArray($recipe->ingredients, array($recipe)))?>

                    <div class="row">

                        <div class="recipe-name">

                            <?=$form->label($recipe, 'title', array('class' => 'row-title'))?><br/>
                            <?=$form->textField($recipe, 'title')?>

                        </div>

                    </div>

                    <div class="row">

                        <div class="product-list">

                            <span class="row-title">Из чего готовим?</span>

                            <table>
                                <?php foreach ($ingredients as $k => $i): ?>
                                    <?php $this->renderPartial('_ingredient', array('n' => $k, 'form' => $form, 'model' => $i, 'units' => ($i->isNewRecord) ? $units : $i->ingredient->availableUnits)); ?>
                                <?php endforeach; ?>

                            </table>

                            <a href="javascript:void(0)" class="add-btn"><i class="icon"></i><span>Добавить ингредиент</span></a>

                        </div>
                        <?php if (Yii::app()->user->id == 10265):?>
                            <a href="http://admin.happy-giraffe.ru/club/CookIngredients/create">создать новый в админке</a>
                        <?php endif ?>

                    </div>

                    <div class="row">

                        <span class="row-title">Описание приготовления</span><br/>

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

                            <span class="row-title">Фото блюда <span>(не обязательно) </span></span>

                            <div class="add-photo<?php if ($recipe->photo_id !== null): ?> uploaded<?php endif; ?>">

                                <?php
                                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                        'model' => $recipe,
                                        'customButton' => true,
                                        'customButtonHtmlOptions' => array('class' => 'fancy attach'),
                                    ));
                                ?>
                                    <?php if ($recipe->photo_id === null): ?>
                                        <span>Загрузите главное<br/>фото Вашего блюда</span><br/>
                                        <i class="icon"></i>
                                    <?php else: ?>
                                        <?=CHtml::image($recipe->photo->getPreviewUrl(325, 252))?>
                                    <?php endif; ?>
                                <?php
                                    $this->endWidget();
                                ?>

                                <?=$form->hiddenField($recipe, 'photo_id')?>

                            </div>

                        </div>

                        <div class="col">

                            <?=$form->label($recipe, 'type', array('class' => 'row-title'))?>

                            <div class="dish-types">
                                <?=$form->radioButtonList($recipe, 'type', $recipe->types, array('template' => '<div class="radio-box">{input} {label}</div>', 'separator' => ''))?>
                            </div>

                        </div>

                    </div>

                    <?php if (get_class($recipe) != 'MultivarkaRecipe'): ?>
                        <div class="row clearfix">

                            <div class="col">

                                <?=$form->label($recipe, 'cuisine_id', array('class' => 'row-title'))?><br/>

                                <span class="chzn-v2">
                                    <?=$form->dropDownList($recipe, 'cuisine_id', CHtml::listData($cuisines, 'id', 'title'), array('prompt' => 'не выбрана', 'class' => 'chzn'))?>
                                </span>

                                <br/>

                                <!--<div class="country">
                                    <div class="flag-big flag-big-ua"></div>Украинская
                                </div>-->

                            </div>

                        </div>
                    <?php endif; ?>

                    <div class="row clearfix ">

                        <div class="times clearfix">

                            <div class="col time-1">
                                <i class="icon"></i>
                                &nbsp;
                                Время подготовки
                                &nbsp;
                                <div class="input">
                                    <?=$form->textField($recipe, 'preparation_duration_h', array('placeholder' => '00'))?>
                                    <br/>
                                    час
                                </div>
                                :
                                <div class="input">
                                    <?=$form->textField($recipe, 'preparation_duration_m', array('placeholder' => '00'))?>
                                    <br/>
                                    мин
                                </div>

                            </div>

                            <div class="col time-2">
                                <i class="icon"></i>
                                &nbsp;
                                Время приготовления
                                &nbsp;
                                <div class="input">
                                    <?=$form->textField($recipe, 'cooking_duration_h', array('placeholder' => '00'))?>
                                    <br/>
                                    час
                                </div>
                                :
                                <div class="input">
                                    <?=$form->textField($recipe, 'cooking_duration_m', array('placeholder' => '00'))?>
                                    <br/>
                                    мин
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <?=$form->label($recipe, 'servings', array('class' => 'row-title'))?>

                        <div class="portions">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <a href="javascript:void(0)" onclick="CookRecipe.selectServings(this)"<?php if ($i == $recipe->servings): ?> class="active"<?php endif; ?>><?=$i?></a>
                            <?php endfor; ?>
                        </div>

                        <?=$form->hiddenField($recipe, 'servings')?>

                    </div>

                    <?php if (Yii::app()->authManager->checkAccess('recipe_tags', Yii::app()->user->id)): ?>
                        <div class="row">
                            <?php echo $form->checkBoxList($recipe, 'tagsIds', CHtml::listData(CookRecipeTag::model()->findAll(), 'id', 'title'), array('uncheckValue' => null)); ?>
                        </div>
                    <?php endif; ?>

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

    <div class="banner-box">

        <?=$this->renderPartial('//_banner')?>

    </div>

</div>

<script id="unitTmpl" type="text/x-jquery-tmpl">
    <li><a href="javascript:void(0)">${title}</a><?=CHtml::hiddenField('unit_id', '${id}')?></li>
</script>

<script id="ingredientTmpl" type="text/x-jquery-tmpl">
    <?php $this->renderPartial('_ingredient', array(
        'n' => '${n}',
        'form' => $form,
        'model' => CookRecipeIngredient::model()->emptyModel,
        'units' => $units,
    )); ?>
</script>