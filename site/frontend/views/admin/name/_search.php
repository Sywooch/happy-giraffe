<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'gender'); ?>
                <?php echo $form->textField($model,'gender'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'translate'); ?>
                <?php echo $form->textField($model,'translate',array('size'=>60,'maxlength'=>512)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'origin'); ?>
                <?php echo $form->textField($model,'origin',array('size'=>60,'maxlength'=>2048)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'name_group_id'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'options'); ?>
                <?php echo $form->textField($model,'options',array('size'=>60,'maxlength'=>512)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'sweet'); ?>
                <?php echo $form->textField($model,'sweet',array('size'=>60,'maxlength'=>512)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'middle_names'); ?>
                <?php echo $form->textField($model,'middle_names',array('size'=>60,'maxlength'=>1024)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'likes'); ?>
                <?php echo $form->textField($model,'likes'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
