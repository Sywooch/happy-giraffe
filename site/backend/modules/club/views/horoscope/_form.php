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
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    return true;
                                return false;
                              }",
    )
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

    <div class="row year month" <?php if (empty($model->year)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'year'); ?>
        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y'), date('Y') + 3)); ?>
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

    <div class="row date month"<?php if (empty($model->month) && !empty($model->year)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 10, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row month" <?php if (empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'good_days'); ?>
        <?php echo $form->textField($model, 'good_days', array('size'=>50)); ?>
        <?php echo $form->error($model, 'good_days'); ?>
    </div>

    <div class="row month" <?php if (empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'bad_days'); ?>
        <?php echo $form->textField($model, 'bad_days', array('size'=>50)); ?>
        <?php echo $form->error($model, 'bad_days'); ?>
    </div>

    <div class="row year" <?php if (empty($model->year) || !empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'health'); ?>
        <?php echo $form->textArea($model, 'health', array('rows' => 6, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'health'); ?>
    </div>

    <div class="row year" <?php if (empty($model->year) || !empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'career'); ?>
        <?php echo $form->textArea($model, 'career', array('rows' => 6, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'career'); ?>
    </div>

    <div class="row year" <?php if (empty($model->year) || !empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'finance'); ?>
        <?php echo $form->textArea($model, 'finance', array('rows' => 6, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'finance'); ?>
    </div>

    <div class="row year" <?php if (empty($model->year) || !empty($model->month)) echo 'style="display: none;"'?>>
        <?php echo $form->labelEx($model, 'personal'); ?>
        <?php echo $form->textArea($model, 'personal', array('rows' => 6, 'cols' => 110)); ?>
        <?php echo $form->error($model, 'personal'); ?>
    </div>

    <div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?= CHtml::submitButton('Сохранить'); ?>
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
        }
        if ($(this).val() == '3'){
            $('.year').show();
        }
    });
</script>