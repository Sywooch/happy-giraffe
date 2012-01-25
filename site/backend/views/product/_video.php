<div class="video">
    <?php $this->widget('DeleteWidget', array(
        'model' => $model,
        'selector' => 'div.video',
    )); ?>
    <?php echo CHtml::image($model->preview, $model->title); ?>
</div>