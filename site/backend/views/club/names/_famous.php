<div class="famous_block edit">
    <?php $this->widget('DeleteWidget', array(
        'modelPk' => $model->id,
        'modelName' => get_class($model),
        'modelAccusativeName' => $model->accusativeName,
        'selector'=>'div.famous_block'
    ));?>
    <?php $model->GetAdminPhoto() ?>

    <p><?php echo $model->name->name.' '.$model->last_name.', '.$model->description ?></p>
</div>