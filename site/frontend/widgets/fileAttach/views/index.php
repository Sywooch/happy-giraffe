<div id="entity_attaches">
<?php echo CHtml::link(
    'Добавить фото',
    array('/albums/album/attach'),
    array('class' => 'fancy attach_link')
); ?>
<?php $this->render('_list', array('attaches' => AttachPhoto::model()->findByEntity($this->model_name, $this->model_id))) ?>
</div>