<style type="text/css">
    input {
        border: 1px solid #777
    }

    #c {
        margin: 10px 0;
    }

    #c td {
        padding: 5px 10px
    }

    #c input[type="text"] {
        width: 250px
    }
</style>







<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'converter-form',
    'action' => CHtml::normalizeUrl(array('converter/calculate')),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('converter/calculate'),
        'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Converter.Calculate();} else { return false;} }",
    )
));
?>


<table id="c">

    <tr>
        <td colspan="4">
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'sourceUrl' => Yii::app()->createUrl('cook/converter/ac'),
                'name' => 'ac',
                'id' => 'ac'
            ));
            echo $form->hiddenField($model, 'ingredient');
            ?>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo $form->textField($model, 'qty'); ?>
        </td>
        <td>
            <select id="ConverterForm_from" name="ConverterForm[from]">
                <?php
                foreach ($units as $unit) {
                    $display = ($unit['type'] == 'qty') ? ' style="display:none" ' : '';
                    echo '<option value="' . $unit['id'] . '" data-id="' . $unit['id'] . '" data-type="' . $unit['type'] . '" data-ratio="' . $unit['ratio'] . '"' . $display . '>' . CHtml::encode($unit['title']) . '</option>';
                }
                ?>
            </select>
        </td>
        <td>
            ->
        </td>
        <td>
            <select id="ConverterForm_to" name="ConverterForm[to]">
                <?php
                foreach ($units as $unit) {
                    $display = ($unit['type'] == 'qty') ? ' style="display:none" ' : '';
                    echo '<option value="' . $unit['id'] . '" data-id="' . $unit['id'] . '" data-type="' . $unit['type'] . '" data-ratio="' . $unit['ratio'] . '"' . $display . '>' . CHtml::encode($unit['title']) . '</option>';
                }
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><?php echo CHtml::submitButton('Перевести'); ?></td>
        <td colspan="3"></td>
    </tr>


</table>

<?php

$form->error($model, 'from');
$form->error($model, 'to');
$form->error($model, 'qty');
$form->error($model, 'ingredient');

echo $form->errorSummary($model);
$this->endWidget();

?>
<div id="result"></div>