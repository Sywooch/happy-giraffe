<h1><?php echo $model->title; ?></h1>
<p><?php echo CHtml::link('Добавить фото', array('photos/add', 'a' => $model->primaryKey), array('class' => 'fancy')); ?></p>
<ul>
    <?php foreach($model->photos as $photo): ?>
        <li>
            <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(100, 100)), $photo->originalUrl, array('class' => 'fancy')); ?>
        </li>
    <?php endforeach; ?>
</ul>
