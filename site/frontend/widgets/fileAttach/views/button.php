<div class="photo <?=$this->entity ?>">
    <?php echo CHtml::link('<span><span>Загрузить фото</span></span>', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id), array(
        'class' => 'btn btn-orange fancy',
        'onclick'=>'Attach.updateEntity(\''.$this->entity.'\', \''.$this->entity_id.'\');'
    )); ?>
    <div class="upload-container"></div>
</div>