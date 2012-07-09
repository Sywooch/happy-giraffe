<?php
/* @var $baby Baby
 */
    $baby_id = $baby->id;
    $day = date('j',strtotime($baby->birthday));
    $month = date('m',strtotime($baby->birthday));
    $year = date('Y',strtotime($baby->birthday));
?>
<div class="form">

    <?php echo CHtml::beginForm() ?>
    <?php echo CHtml::hiddenField('baby_id', $baby_id) ?>

    <div class="vaccination-birthday">
        <big>День рождения:</big>   <?php echo Yii::app()->dateFormatter->format('d MMMM y', strtotime($baby->birthday)) ?>
        <?php echo CHtml::ajaxLink('<span><span>Рассчитать</span></span>',$this->createUrl('default/vaccineTable'),array(
                'type'=>'POST',
                'data'=>'baby_id='.$baby_id,
                'success'=>'function(data){$("#vaccine-result'.$baby_id.'").html(data);}'
            ),
            array(
                'class'=>'btn btn-yellow-medium'
            )); ?>
    </div>

    <?php echo CHtml::endForm() ?>

</div>
<div id="vaccine-result<?php echo $baby_id ?>">

</div>
<?php $this->renderPartial('_text'); ?>