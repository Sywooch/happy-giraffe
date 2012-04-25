<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Horoscope
 */
?>
<?php echo CHtml::link('К таблице', array('/club/horoscope/admin')) ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'horoscope-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'zodiac'); ?>
		<?php echo $form->dropDownList($model,'zodiac', $model->zodiac_list); ?>
		<?php echo $form->error($model,'zodiac'); ?>
	</div>

    <div class="row">
        <label for="zodiac-type">Тип прогноза</label>
        <select id="zodiac-type" name="Horoscope[type]">
            <option value="1">на конкретную дату</option>
            <option value="2">на неделю</option>
            <option value="3">на месяц</option>
            <option value="4">на год</option>
        </select>
    </div>

    <div class="row year" style="display: none;">
        <?php echo $form->labelEx($model,'year'); ?>
        <?php echo $form->dropDownList($model,'year', HDate::Range(date('Y'), date('Y') +1)); ?>
        <?php echo $form->error($model,'year'); ?>
    </div>

    <div class="row month" style="display: none;">
        <?php echo $form->labelEx($model,'month'); ?>
        <?php echo $form->dropDownList($model,'month', HDate::ruMonths()); ?>
        <?php echo $form->error($model,'month'); ?>
    </div>

    <div class="row week" style="display: none;">
        <?php echo $form->labelEx($model,'week'); ?>
        <?php echo $form->dropDownList($model,'week', HDate::Range(1, 52)); ?>
        <?php echo $form->error($model,'week'); ?>
        <div>Текущая неделя - <?=date('W') ?></div>
        <br>
    </div>

	<div class="row date">
		<?php echo $form->labelEx($model,'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model'=>$model,
        'attribute'=>'date',
        'language'=>'ru',
        'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
        ),
        'htmlOptions'=>array(
            'style'=>'height:20px;'
        ),
    )); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>15, 'cols'=>110)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $('#zodiac-type').change(function(){
        $('.date').hide();
        $('.week').hide();
        $('.month').hide();
        $('.year').hide();

        if ($(this).val() == '1')
            $('.date').show();
        if ($(this).val() == '2'){
            $('.week').show();
            $('.year').show();
        }
        if ($(this).val() == '3'){
            $('.month').show();
            $('.year').show();
        }
        if ($(this).val() == '4')
            $('.year').show();
    });
</script>