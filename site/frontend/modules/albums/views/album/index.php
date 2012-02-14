<p><?php echo CHtml::link('Создать альбом', array('album/create')); ?></p>
<ul>
<?php foreach($dataProvider->getData() as $model): ?>
    <li><?php echo CHtml::link($model->title, array('album/view', 'id' => $model->id)); ?></li>
<?php endforeach; ?>
</ul>