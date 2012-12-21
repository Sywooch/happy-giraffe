<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $date DateForm
 */
?>
<div class="vaccination-birthday form">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'date-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => $this->createUrl('default/validateDate'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('default/validateDate'),
        'afterValidate' => "js:function(form, data, hasError) {
                  if (!hasError) {
                      $.ajax({
                          url: '" . $this->createUrl('default/vaccineTable') . "',
                          type: 'POST',
                          data: $('#date-form').serialize(),
                          success: function(data) {
                              $('#vaccine-result').html(data);
                          }
                      });
                  }
                  return false;
              }",
    ))); ?>

    <big>День рождения:</big>

    <div class="row">
        <?php echo $form->dropDownList($date, 'day', HDate::Days(), array('class' => 'chzn', 'empty' => 'День')); ?>
        <?php echo $form->error($date, 'day'); ?>
    </div>
    <div class="row">
        <?php echo $form->dropDownList($date, 'month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => 'Месяц')); ?>
        <?php echo $form->error($date, 'month'); ?>
    </div>
    <div class="row">
        <?php echo $form->dropDownList($date, 'year', HDate::Range(1990, 2020), array('class' => 'chzn', 'empty' => 'Год')); ?>
        <?php echo $form->error($date, 'year'); ?>
    </div>
    <?php echo CHtml::hiddenField('baby_id', '') ?>

    <?php echo CHtml::link('<span><span>Рассчитать</span></span>', '#', array(
        'class' => 'btn btn-yellow-medium',
        'onclick'=>'js:$("#date-form").submit();return false;'
    )); ?>
    <div class="clear"></div>

    <?php $this->endWidget(); ?>
</div>
<div id="vaccine-result">

</div>
<?php $this->renderPartial('_text'); ?>