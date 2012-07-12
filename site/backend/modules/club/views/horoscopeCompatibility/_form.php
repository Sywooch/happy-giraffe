<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
echo CHtml::link('К таблице', array('HoroscopeCompatibility/admin'));
$list2 = array();
if (!empty($model->zodiac1))
    $list2 = $model->getAvailableZodiacs();
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'horoscope-compatibility-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
    )));?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'zodiac1'); ?>
        <?php echo $form->dropDownList($model, 'zodiac1', Horoscope::model()->zodiac_list, array('empty' => ' ')); ?>
        <?php echo $form->error($model, 'zodiac1'); ?>
    </div>

    <div class="row" id="zodiac-2">
        <?php echo $form->labelEx($model, 'zodiac2'); ?>
        <?php echo $form->dropDownList($model, 'zodiac2', $list2); ?>
        <?php echo $form->error($model, 'zodiac2'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?= CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    var zodiacs = ['Овен', 'Телец', 'Близнецы', 'Рак', 'Лев', 'Дева', 'Весы', 'Скорпион', 'Стрелец', 'Козерог', 'Водолей', 'Рыбы'];
    $(function () {
        $('#HoroscopeCompatibility_zodiac1').change(function () {
            var z1 = $('#HoroscopeCompatibility_zodiac1').val();

            $("#HoroscopeCompatibility_zodiac2 option").remove();
            for (var i = z1 - 1; i < 12; i++) {
                $('#HoroscopeCompatibility_zodiac2').append($('<option></option>').val(i + 1).html(zodiacs[i]));
            }
        });
    });
</script>