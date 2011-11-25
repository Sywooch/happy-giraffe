<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'vaccine_id'); ?>
                <?php echo $form->textField($model,'vaccine_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'time_from'); ?>
                <?php echo $form->textField($model,'time_from',array('size'=>4,'maxlength'=>4)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'time_to'); ?>
                <?php echo $form->textField($model,'time_to',array('size'=>4,'maxlength'=>4)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'adult'); ?>
                <?php echo $form->textField($model,'adult'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'interval'); ?>
                <?php echo $form->textField($model,'interval'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'every_period'); ?>
                <?php echo $form->textField($model,'every_period'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'age_text'); ?>
                <?php echo $form->textField($model,'age_text',array('size'=>60,'maxlength'=>256)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'vaccination_type'); ?>
                <?php echo $form->textField($model,'vaccination_type'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
