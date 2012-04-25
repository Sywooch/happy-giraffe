<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1>Расчет материалов для подвесного потолка</h1>
<div id="repairFlooring">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'SuspendedCeiling-calculate-form',
        'action' => $this->createUrl('suspendedCeiling/calculate'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('suspendedCeiling/calculate'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    SuspendedCeiling.Calculate();
                                return false;
                              }",
        )));
    ?>
    <table>

        <tr>
            <td><?php echo $form->labelEx($SuspendedCeilingModel, 'plate') ?></td>
            <td><?php echo $form->dropDownList($SuspendedCeilingModel, 'plate', $SuspendedCeilingModel->plateTypes) ?></td>
            <td><?php echo $form->error($SuspendedCeilingModel, 'plate') ?></td>
        </tr>

        <tr>
            <td><?php echo $form->labelEx($SuspendedCeilingModel, 'area') ?></td>
            <td><?php echo $form->textField($SuspendedCeilingModel, 'area') ?></td>
            <td><?php echo $form->error($SuspendedCeilingModel, 'area') ?></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton('Рассчитать'); ?></td>
            <td>&nbsp;</td>
        </tr>


    </table>
    <?php $this->endWidget(); ?>


    <div id="result">
    </div>
</div>
