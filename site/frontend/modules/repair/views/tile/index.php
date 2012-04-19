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
        <td><?php echo $form->labelEx($tileModel, 'roomLength') ?></td>
        <td><?php echo $form->textField($tileModel, 'roomLength') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'roomLength') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'roomWidth') ?></td>
        <td><?php echo $form->textField($tileModel, 'roomWidth') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'roomWidth') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($tileModel, 'roomHeight') ?></td>
        <td><?php echo $form->textField($tileModel, 'roomHeight') ?></td>
        <td>м</td>
        <td><?php echo $form->error($tileModel, 'roomHeight') ?></td>
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

<h2>Необкладываемык области</h2>
<div id="emptyareas"></div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'area-form',
    'action' => $this->createUrl('tile/areaAdd'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('tile/areaAdd'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Tile.AreaCreate();
                                return false;
                              }",
    )));
?>

<?php //echo $form->errorSummary($emptyArea); ?>

<table>
    <tr>
        <td><?php echo $form->labelEx($area, 'title') ?></td>
        <td><?php echo $form->textField($area, 'title') ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->error($area, 'title') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($area, 'height') ?></td>
        <td><?php echo $form->textField($area, 'height') ?></td>
        <td>м</td>
        <td><?php echo $form->error($area, 'height') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($area, 'width') ?></td>
        <td><?php echo $form->textField($area, 'width') ?></td>
        <td>м</td>
        <td><?php echo $form->error($area, 'width') ?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton('Добавить необклеиваемую область'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>


</table>
<?php $this->endWidget(); ?>

<div id="result">
</div>
    </div>
