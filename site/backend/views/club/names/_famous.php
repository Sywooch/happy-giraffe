<div class="famous_block edit <?php echo 'id'.$model->id ?>">
    <?php $this->widget('DeleteWidget', array(
        'modelPk' => $model->id,
        'modelName' => get_class($model),
        'modelAccusativeName' => $model->accusativeName,
        'selector'=>'div.famous_block'
    ));?>
    <?php echo CHtml::image($model->GetUrl(), '', array('class'=>'person-photo')) ?>

    <p><?php echo $model->name->name.' '.$model->last_name.', '.$model->description ?></p>
</div>