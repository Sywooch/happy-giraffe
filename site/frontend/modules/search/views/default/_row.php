<?php if (in_array($data->entity, array('post', 'video'))): ?>
    <?php $this->renderPartial('//community/_post', array('data' => $data, 'full' => false)); ?>
<?php endif; ?>

<?php if ($data->entity == 'photo'): ?>
    <?php $this->renderPartial('//albums/favourites', array('model' => $data)); ?>
<?php endif; ?>