<?php
    $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'recipe' . DIRECTORY_SEPARATOR . 'assets';
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    Yii::app()->clientScript->
        registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
    ;
?>

<script id="unitTmpl" type="text/x-jquery-tmpl">
    <li><a href="javascript:void(0)">${title}</a><?=CHtml::hiddenField('unit_id', '${id}')?></li>
</script>

<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Приправы и специи</span></div>

<div class="main">

    <div class="main-right">

        <div id="cook-add-recipe">

        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'addRecipeForm')); ?>

                <div class="form-in">

                    <div class="title"><i class="icon"></i>Добавить рецепт</div>

                    <?=$form->errorSummary(array($recipe) + $ingredients)?>

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
                                    <?php $this->renderPartial('_ingredient', array('n' => $k, 'form' => $form, 'model' => $i, 'units' => $units)); ?>
                                <?php endforeach; ?>

                            </table>

                            <a href="javascript:void(0)" class="add-btn"><i class="icon"></i><span>Добавить ингредиент</span></a>

                        </div>

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

                            <div class="add-photo">

                                <?php
                                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                        'model' => $recipe,
                                        'fixAsap' => true,
                                    ));
                                    $fileAttach->button();
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

                        <div class="col">

                            <?=$form->label($recipe, 'method', array('class' => 'row-title'))?><br/>

                            <span class="chzn-v2">
                                <?=$form->dropDownList($recipe, 'method', $recipe->methods, array('prompt' => 'не выбран', 'class' => 'chzn'))?>
                            </span>

                        </div>

                    </div>

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
                                <a href="javascript:void(0)" onclick="selectServings(this)"<?php if ($i == $recipe->servings): ?> class="active"<?php endif; ?>><?=$i?></a>
                            <?php endfor; ?>
                        </div>

                        <?=$form->hiddenField($recipe, 'servings')?>

                    </div>

                </div>

                <div class="row-btn">

                    <button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
                    <button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>
                    <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>

                </div>

            <?php $this->endWidget(); ?>

            <?php $this->renderPartial('_js', array('count' => count($ingredients), 'form' => $form, 'model' => CookRecipeIngredient::model()->emptyModel, 'units' => $units)); ?>

        </div>

    </div>

</div>

<div class="side-right">

    <div class="banner-box">

        <a href=""><img src="/images/banner_04.png" /></a>

    </div>

</div>

<?php if (false): ?>
    <?=CHtml::errorSummary(array($recipe) + $ingredients)?>

    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'addRecipeForm')); ?>

        <div>
            <p><?php echo $form->labelEx($recipe, 'title'); ?></p>
            <p><?php echo $form->textField($recipe, 'title'); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'ingredients'); ?></p>
            <?php foreach ($ingredients as $k => $i): ?>
                <?php $this->renderPartial('_ingredient', array('n' => $k, 'form' => $form, 'model' => $i, 'units' => $units)); ?>
            <?php endforeach; ?>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'preparation_duration'); ?></p>
            <p><?php echo $form->textField($recipe, 'preparation_duration_h', array('size' => 2)); ?>:<?php echo $form->textField($recipe, 'preparation_duration_m', array('size' => 2)); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'cooking_duration'); ?></p>
            <p><?php echo $form->textField($recipe, 'cooking_duration_h', array('size' => 2)); ?>:<?php echo $form->textField($recipe, 'cooking_duration_m', array('size' => 2)); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'cuisine_id'); ?></p>
            <p><?php echo $form->dropDownList($recipe, 'cuisine_id', CHtml::listData($cuisines, 'id', 'title'), array('prompt' => '---')); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'type'); ?></p>
            <p><?php echo $form->dropDownList($recipe, 'type', $recipe->types, array('prompt' => '')); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'method'); ?></p>
            <p><?php echo $form->dropDownList($recipe, 'method', $recipe->methods, array('prompt' => '')); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'servings'); ?></p>
            <p><?php echo $form->textField($recipe, 'servings'); ?></p>
        </div>

        <div>
            <p><?php echo $form->labelEx($recipe, 'text'); ?></p>
            <p><?php echo $form->textArea($recipe, 'text'); ?></p>
        </div>

        <?=CHtml::submitButton('Сохранить')?>

    <?php $this->endWidget(); ?>

<?php endif; ?>