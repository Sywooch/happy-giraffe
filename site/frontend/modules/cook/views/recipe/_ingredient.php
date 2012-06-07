<tr>
    <td class="col-1">
        <?=$form->textField($model, '[' . $n . ']' . 'title', array('placeholder' => 'Название продукта', 'class' => 'inAc'))?>
        <?=$form->hiddenField($model, '[' . $n . ']' . 'ingredient_id')?>
    </td>
    <td class="col-2">
        <?=$form->textField($model, '[' . $n . ']' . 'value', array('placeholder' => 0))?>
    </td>
    <td class="col-3">
        <div class="drp-list">
            <?php $this->renderPartial('_units', array('units' => $units, 'unit' => $model->unit, 'n' => $n)); ?>
            <?=$form->hiddenField($model, '[' . $n . ']' . 'unit_id')?>
        </div>
    </td>
    <td class="col-4"><a href="javascript:void(0)" class="remove tooltip" title="Удалить ингредиент"></a></td>
</tr>

<?php if (false): ?>
    <div>
        <p>
            Продукт:
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name' => 'CookRecipeIngredient[' . $n . ']title',
                'sourceUrl' => '/cook/recipe/ac/',
                'options' => array(
                    'minLength' => '2',
                    'select' => 'js: function(event, ui) {
                        $(\'#CookRecipeIngredient_' . $n . '_ingredient_id\').val(ui.item.id);
                    }',
                ),
            )); ?>

            <?=$form->hiddenField($model, '[' . $n . ']' . 'ingredient_id')?>
        </p>
        <p>Кол-во: <?=$form->textField($model, '[' . $n . ']' . 'value')?></p>
        <p>Мера: <?=$form->dropDownList($model, '[' . $n . ']' . 'unit_id', CHtml::listData($units, 'id', 'title'), array('prompt' => 'не выбрано'))?></p>
    </div>
<?php endif; ?>