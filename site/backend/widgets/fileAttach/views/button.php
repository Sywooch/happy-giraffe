<div class="photo <?=$this->entity ?>">
    <?php echo CHtml::link('<span><span>'.$this->first_button_title.'</span></span>', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id), array(
        'class' => 'btn fancy '.$this->first_button_class,
        'onclick'=>$this->id . '.updateEntity(\''.$this->entity.'\', \''.$this->entity_id.'\');'
    )); ?>
    <div class="upload-container"></div>
</div>