<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1>Расчет плитки для ванной комнаты</h1>
<div id="repearWallpapers">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'tile-calculate-form',
    'action' => $this->createUrl('tile/calculate'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('tile/calculate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Tile.Calculate();
                                return false;
                              }",
    )));
?>

<table>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'wallLength') ?></td>
        <td><?php echo $form->textField($tileModel, 'wallLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'wallLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'roomHeight') ?></td>
        <td><?php echo $form->textField($tileModel, 'roomHeight') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'roomHeight') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'bathLength') ?></td>
        <td><?php echo $form->textField($tileModel, 'bathLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'bathLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'bathHeight') ?></td>
        <td><?php echo $form->textField($tileModel, 'bathHeight') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'bathHeight') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'doorHeight') ?></td>
        <td><?php echo $form->textField($tileModel, 'doorHeight') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'doorHeight') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'doorWidth') ?></td>
        <td><?php echo $form->textField($tileModel, 'doorWidth') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'doorWidth') ?></td>
    </tr>



    <tr>
        <td><?php echo $form->labelEx($tileModel, 'tileLength') ?></td>
        <td><?php echo $form->textField($tileModel, 'tileLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'tileLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'tileWidth') ?></td>
        <td><?php echo $form->textField($tileModel, 'tileWidth') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'tileWidth') ?></td>
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
