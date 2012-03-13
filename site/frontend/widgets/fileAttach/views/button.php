<div class="photo">
    <?php echo CHtml::link('<span><span>Загрузить фото</span></span>', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id), array(
        'class' => 'btn btn-orange fancy',
    )); ?>
</div>