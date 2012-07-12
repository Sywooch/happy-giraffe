<?php
/* @var $this Controller
 * @var $model CookIngredient
 */
Yii::app()->clientScript->registerCssFile('http://www.happy-giraffe.ru/stylesheets/admin.css');
Yii::app()->clientScript->registerCssFile('http://www.happy-giraffe.ru/stylesheets/common.css');
?>
<div class="content-title"><?=$model->title;?></div>

<div id="admin-cook-measures">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-form',
    'enableAjaxValidation' => false,
    'method' => 'POST'
)); ?>
    <div class="form form-horizontal">
        <div>
        <?= $form->errorSummary($model); ?>
        </div>

        <div class="row clearfix">
            <?=$form->labelEx($model, 'title');?>
            <?=$form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'class' => 'big'));?>
            <?=$form->error($model, 'title');?>
        </div>
        <div class="row clearfix">
            <?=$form->labelEx($model, 'category_id');?>
            <div class="row-in">
                <?=$form->dropDownList($model, 'category_id', CookIngredientCategory::getCategories());?>
            </div>
            <?=$form->error($model, 'category_id');?>
        </div>
        <div class="row clearfix">
            <?=$form->labelEx($model, 'unit_id');?>
            <?=$form->dropDownList($model, 'unit_id', CookUnit::getUnits());?>
            <?=$form->error($model, 'unit_id');?>
        </div>
        <div class="row clearfix">
            <?=$form->labelEx($model, 'density');?>
            <?=$form->textField($model, 'density', array('size' => 10, 'maxlength' => 10));?>
            <?=$form->error($model, 'density');?>
        </div>

    </div>


    <div class="col">
        <label>Единицы измерения</label>
        <?php
        $units = CookUnit::model()->findAll(array('order' => 'type'));
        $iUnits = $model->getUnits();
        $iUnitsIds = $model->getUnitsIds();

        foreach ($units as $unit) {
            $active = (in_array($unit->id, $iUnitsIds)) ? 'checked="checked"' : '';
            if ($unit->type != 'qty') {
                echo '<span class="checkbox">';
                echo '<input name="units[' . $unit->id . '][cb]" type="checkbox" value="' . $unit->id . '" ' . $active . ' id="unitt-' . $unit->id . '">';
                echo '<label for="unitt-' . $unit->id . '">' . $unit->title . '</label>';
                echo '</span>';
            }
        }
        ?>
    </div>

    <div class="col" id="nutritionals">
        <label>Состав продукта <span>(на 100 гр.)</span></label>

        <div class="value-row">
            <span>Калорийность</span> <?= CHtml::textField('nutritional[1]', $model->getNutritional(1)) ?> ккал
        </div>
        <div class="value-row">
            <span>Белки</span> <?= CHtml::textField('nutritional[3]', $model->getNutritional(3)) ?> грамм
        </div>
        <div class="value-row">
            <span>Жиры</span> <?= CHtml::textField('nutritional[2]', $model->getNutritional(2)) ?> грамм
        </div>
        <div class="value-row">
            <span>Углеводы</span> <?= CHtml::textField('nutritional[4]', $model->getNutritional(4)) ?> грамм
        </div>
    </div>

    <div class="col">
        <label>Вес единицы продукта <span>(гр.)</span></label>
        <?php

        foreach ($units as $unit) {
            $weight = (in_array($unit->id, $iUnitsIds)) ? $iUnits[$unit->id]['weight'] : '';
            if ($unit->type == 'qty') {
                echo '<div class="value-row">';
                echo '<span>' . $unit->title . '</span>';
                echo '<input name="units[' . $unit->id . '][weight]" type="text" value="' . $weight . '" class="short">';
                echo '</div>';
            }
        }
        ?>
        <a href="cookUnit/create/" target="_blank">добавить</a>
    </div>

    <div class="synonyms col">
        <label>Синонимы</label>
        <?php $i = 0; ?>
        <?php foreach ($model->synonyms as $synonym): ?>
        <div class="value-row">
            <input type="text" name="synonym[<?=$i ?>]" value="<?=$synonym->title ?>" id="synonym-<?=$i ?>">
        </div>
        <?php $i++; ?>
        <?php endforeach; ?>

        <div class="value-row">
            <input type="text" name="synonym[<?=$i ?>]" value="" id="synonym-<?=$i ?>">
        </div>
    </div>

    <div class="row-btn">
        <button class="btn btn-green"><span><span>Сохранить</span></span></button>
    </div>

    <?php $this->endWidget(); ?>

</div>
<script type="text/javascript">
    $(function () {
        $('body').delegate('.synonyms input', 'keyup', function () {
            var i = $(this).attr("id").replace(/[a-zA-Z]*-/ig, "");
            i = parseInt(i + 1);
            if ($('#synonym-' + i).length <= 0) {
                $('.synonyms').append('<div class="value-row"><input type="text" name="synonym[' + i + ']" value="" id="synonym-' + i + '"></div>');
            }
        });
    });
</script>