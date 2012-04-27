<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1>Расчета объема краски</h1>
<div id="repearWallpapers">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'wallpapers-calculate-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => $this->createUrl('paint/calculate'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('paint/calculate'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Wallpapers.StartCalc();
                                return false;
                              }",
        )));
    ?>


    <?php //echo $form->errorSummary($model); ?>

    <table>
        <tr>
            <td><?php echo $form->labelEx($model, 'roomLength') ?></td>
            <td><?php echo $form->textField($model, 'roomLength') ?></td>
            <td>м</td>
            <td><?php echo $form->error($model, 'roomLength') ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'roomWidth') ?></td>
            <td><?php echo $form->textField($model, 'roomWidth') ?></td>
            <td>м</td>
            <td><?php echo $form->error($model, 'roomWidth') ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'roomHeight') ?></td>
            <td><?php echo $form->textField($model, 'roomHeight') ?></td>
            <td>м</td>
            <td><?php echo $form->error($model, 'roomHeight') ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton('Рассчитать'); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>


    </table>
    <?php $this->endWidget(); ?>

    <h2>Неокрашиваемые области</h2>

    <div id="emptyareas"></div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'empty-area-form',
        'action' => $this->createUrl('paint/addemptyarea'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('paint/addemptyarea'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Paint.AreaCreate();
                                return false;
                              }",
        )));
    ?>

    <?php //echo $form->errorSummary($emptyArea); ?>

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
            <td><?php echo $form->labelEx($emptyArea, 'qty') ?></td>
            <td><?php echo $form->textField($emptyArea, 'qty') ?></td>
            <td>м</td>
            <td><?php echo $form->error($emptyArea, 'qty') ?></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton('Добавить неокрашиваемую область'); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>


    </table>
    <?php $this->endWidget(); ?>

    <div id="result">
    </div>
</div>
