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