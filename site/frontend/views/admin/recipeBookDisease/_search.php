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
                <?php echo $form->label($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'category_id'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'with_recipies'); ?>
                <?php echo $form->checkBox($model,'with_recipies'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'reasons_name'); ?>
                <?php echo $form->textField($model,'reasons_name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'symptoms_name'); ?>
                <?php echo $form->textField($model,'symptoms_name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'treatment_name'); ?>
                <?php echo $form->textField($model,'treatment_name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'prophylaxis_name'); ?>
                <?php echo $form->textField($model,'prophylaxis_name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'reasons_text'); ?>
                <?php echo $form->textArea($model,'reasons_text',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'symptoms_text'); ?>
                <?php echo $form->textArea($model,'symptoms_text',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'treatment_text'); ?>
                <?php echo $form->textArea($model,'treatment_text',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'prophylaxis_text'); ?>
                <?php echo $form->textArea($model,'prophylaxis_text',array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
