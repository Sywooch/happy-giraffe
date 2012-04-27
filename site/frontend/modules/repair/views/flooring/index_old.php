<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1>Расчет напольного покрытия</h1>
<div id="repairFlooring">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'flooring-calculate-form',
    'action' => $this->createUrl('flooring/calculate'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('flooring/calculate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Flooring.Calculate();
                                return false;
                              }",
    )));
?>
<input type="hidden" name="t" value="<?=$FlooringModel->t?>">
<table>

    <tr>
        <td><?php echo $form->labelEx($FlooringModel, 'flooringType') ?></td>
        <td><?php echo $form->dropDownList($FlooringModel, 'flooringType', $FlooringModel->flooringTypes, array('onchange'=>'Flooring.typeChanged($(this)); return false;') ) ?></td>
        <td>м</td>
        <td><?php echo $form->error($FlooringModel, 'flooringType') ?></td>
    </tr>

    <tr>
        <td><?php echo $form->labelEx($FlooringModel, 'flooringLength') ?></td>
        <td><?php echo $form->textField($FlooringModel, 'flooringLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($FlooringModel, 'flooringLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($FlooringModel, 'flooringWidth') ?></td>
        <td><?php echo $form->textField($FlooringModel, 'flooringWidth') ?></td>
        <td>м</td>
        <td><?php echo $form->error($FlooringModel, 'flooringWidth') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($FlooringModel, 'floorLength') ?></td>
        <td><?php echo $form->textField($FlooringModel, 'floorLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($FlooringModel, 'floorLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($FlooringModel, 'floorWidth') ?></td>
        <td><?php echo $form->textField($FlooringModel, 'floorWidth') ?></td>
        <td>м</td>
        <td><?php echo $form->error($FlooringModel, 'floorWidth') ?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton('Рассчитать'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>


</table>
<?php $this->endWidget(); ?>


<div id="result">
</div>
    </div>
