<?php
/* @var $this Controller
 * @var $model CookIngredient
 */
?><h1><?=$model->title;?></h1>

<style type="text/css">
    table.iform td, th {
        padding: 2px 5px
    }

    div.form {
        margin: 15px 0;
        padding: 5px;
        border: 1px solid #CCC
    }

    table#fcontainer {
        width: 100%
    }

    table#fcontainer td {
        vertical-align: top;
        padding: 0 10px
    }

    h1 {
        padding-bottom: 10px
    }
</style>

<?php echo CHtml::link('К таблице', array('club/CookIngredient/admin')) ?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-form',
    'enableAjaxValidation' => false,
    'method'=>'POST'
)); ?>

<div class="form">

    <?php echo $form->errorSummary($model); ?>

    <table class="iform general">
        <tr>
            <td><?=$form->labelEx($model, 'title');?></td>
            <td><?=$form->textField($model, 'title', array('size' => 60, 'maxlength' => 255));?></td>
            <td><?=$form->error($model, 'title');?></td>
        </tr>
        <tr>
            <td><?=$form->labelEx($model, 'category_id');?></td>
            <td><?=$form->dropDownList($model, 'category_id', CookIngredientCategory::getCategories());?></td>
            <td><?=$form->error($model, 'category_id');?></td>
        </tr>
        <?php
        if (!$model->isNewRecord) {
            ?>
            <tr>
                <td><?=$form->labelEx($model, 'unit_id');?></td>
                <td><?=$form->dropDownList($model, 'unit_id', CookUnit::getUnits());?></td>
                <td><?=$form->error($model, 'unit_id');?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><?=$form->labelEx($model, 'density');?></td>
            <td><?=$form->textField($model, 'density', array('size' => 10, 'maxlength' => 10));?></td>
            <td><?=$form->error($model, 'density');?></td>
        </tr>
    </table>

</div>

<div id="nutritionals">
    <?= CHtml::textField('nutritional[1]', $model->getNutritional(1)) ?><br>
    <?= CHtml::textField('nutritional[3]', $model->getNutritional(3)) ?><br>
    <?= CHtml::textField('nutritional[2]', $model->getNutritional(2)) ?><br>
    <?= CHtml::textField('nutritional[4]', $model->getNutritional(4)) ?><br>
</div>

<div>
    <?php
    $units = CookUnit::model()->findAll(array('order' => 'type'));
    $iUnits = $model->getUnits();
    $iUnitsIds = $model->getUnitsIds();

    foreach ($units as $unit) {
        $active = (in_array($unit->id, $iUnitsIds)) ? 'checked="checked"' : '';
        if ($unit->type != 'qty') {
            echo '<div>';
            echo '<input name="units[' . $unit->id . '][cb]" type="checkbox" value="' . $unit->id . '" ' . $active . '>';
            echo '<label>' . $unit->title . '</label>';
            echo '</div>';
        }
    }

    foreach ($units as $unit) {
        $weight = (in_array($unit->id, $iUnitsIds)) ? $iUnits[$unit->id]['weight'] : '';
        if ($unit->type == 'qty') {
            echo '<div>';
            echo '<input name="units[' . $unit->id . '][weight]" type="text" value="' . $weight . '">';
            echo '<label>' . $unit->title . '</label>';
            echo '</div>';
        }
    }
    ?>
</div>

<div class="synonyms">
    <h2>Синонимы</h2>
    <?php $i = 0; ?>
    <?php foreach ($model->synonyms as $synonym): ?>
        <input type="text" name="synonym[<?=$i ?>]" value="<?=$synonym->title ?>" id="synonym-<?=$i ?>">
        <?php $i++; ?>
    <?php endforeach; ?>

    <input type="text" name="synonym[<?=$i ?>]" value="" id="synonym-<?=$i ?>">
</div>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var IngredientEdit = {

    }

    $(function() {
        $('body').delegate('.synonyms input', 'keydown', function(){
            var i = $(this).attr("id").replace(/[a-zA-Z]*-/ig, "");
            i = parseInt(i+1);
            if ($('#synonym-'+i).length <= 0){
                $('.synonyms').append('<input type="text" name="synonym['+i+']" value="" id="synonym-'+i+'">');
            }
        });
    });
</script>