<?php if (in_array($data->entity, array('post', 'video'))): ?>
    <?php $this->render('//community/_post', array('data' => $data)); ?>
<?php endif; ?>

<?php if ($data->entity == 'photo'): ?>
    <?php $this->render('//albums/')
<?php endif; ?>