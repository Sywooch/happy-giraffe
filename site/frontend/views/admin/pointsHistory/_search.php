<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'note'); ?>
                <?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'amount'); ?>
                <?php echo $form->textField($model,'amount',array('size'=>5,'maxlength'=>5)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'user_id'); ?>
                <?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
