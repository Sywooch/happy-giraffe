<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Horoscope
 */
?>
<?php echo CHtml::link('К таблице', array('horoscope/admin')) ?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'horoscope-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'zodiac'); ?>
        <?php echo $form->dropDownList($model, 'zodiac', $model->zodiac_list); ?>
        <?php echo $form->error($model, 'zodiac'); ?>
    </div>

    <div class="row">
        <label for="zodiac-type">Тип прогноза</label>
        <select id="zodiac-type" name="Horoscope[type]">
            <option value="1"<?php if (!empty($model->date)) echo ' selected="selected"'?>>на конкретную дату</option>
            <option value="2"<?php if ($model->onMonth()) echo ' selected="selected"'?>>на месяц</option>
            <option value="3"<?php if ($model->onYear()) echo ' selected="selected"'?>>на год</option>
        </select>
    </div>

    <div class="row year" <?php if (empty($model->year)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'year'); ?>
        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y'), date('Y') + 1)); ?>
        <?php echo $form->error($model, 'year'); ?>
    </div>

    <div class="row month" <?php if (empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'month'); ?>
        <?php echo $form->dropDownList($model, 'month', HDate::ruMonths()); ?>
        <?php echo $form->error($model, 'month'); ?>
    </div>

    <div class="row date" <?php if (empty($model->date) && !$model->isNewRecord) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $model,
        'attribute' => 'date',
        'language' => 'ru',
        'options' => array(
            'showAnim' => 'fold',
            'dateFormat' => 'yy-mm-dd',
        ),
        'htmlOptions' => array(
            'style' => 'height:20px;'
        ),
    )); ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 15, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::submitButton('Создать', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        } else {
            echo CHtml::submitButton('Сохранить');
            echo CHtml::submitButton('Сохранить и продолжить', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $('#zodiac-type').change(function () {
        $('.date').hide();
        $('.week').hide();
        $('.month').hide();
        $('.year').hide();

        if ($(this).val() == '1')
            $('.date').show();
        if ($(this).val() == '2') {
            $('.month').show();
            $('.year').show();
        }
        if ($(this).val() == '3')
            $('.year').show();
    });
</script>