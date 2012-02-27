<p><?php echo CHtml::link('Добавить фото', array('photos/add'), array('class' => 'fancy')); ?></p>
<ul>
    <?php foreach ($dataProvider->getData() as $model): ?>
    <li><?php echo CHtml::link($model->title, array('album/attachView', 'id' => $model->id)); ?></li>
    <?php endforeach; ?>
</ul>