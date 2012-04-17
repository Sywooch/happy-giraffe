<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1>Расчет обоев</h1>
<div id="repearWallpapers">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'wallpapers-calculate-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/repear/wallpapers/calculate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    )));
?>


<?php //echo $form->errorSummary($model); ?>

<table>
    <tr>
        <td><?php echo $form->labelEx($model, 'room_length') ?></td>
        <td><?php echo $form->textField($model, 'room_length') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'room_length') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'room_width') ?></td>
        <td><?php echo $form->textField($model, 'room_width') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'room_width') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'room_height') ?></td>
        <td><?php echo $form->textField($model, 'room_height') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'room_height') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'wp_width') ?></td>
        <td><?php echo $form->textField($model, 'wp_width') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'wp_width') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'wp_length') ?></td>
        <td><?php echo $form->textField($model, 'wp_length') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'wp_length') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'repeat') ?></td>
        <td><?php echo $form->textField($model, 'repeat') ?></td>
        <td>м</td>
        <td><?php echo $form->error($model, 'repeat') ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton('Рассчитать'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>


</table>
<?php $this->endWidget(); ?>

<h2>Необклеиваемые области</h2>
<div id="emptyareas"></div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'empty-area-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/repear/wallpapers/addemptyarea'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    AddEmptyArea();
                                return false;
                              }",
    )));
?>

<?php echo $form->errorSummary($emptyArea); ?>

<table>
    <tr>
        <td><?php echo $form->labelEx($emptyArea, 'title') ?></td>
        <td><?php echo $form->textField($emptyArea, 'title') ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->error($emptyArea, 'title') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($emptyArea, 'height') ?></td>
        <td><?php echo $form->textField($emptyArea, 'height') ?></td>
        <td>м</td>
        <td><?php echo $form->error($emptyArea, 'height') ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($emptyArea, 'width') ?></td>
        <td><?php echo $form->textField($emptyArea, 'width') ?></td>
        <td>м</td>
        <td><?php echo $form->error($emptyArea, 'width') ?></td>
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
