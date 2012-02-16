<h5><?php echo $model->title; ?></h5>
<ul>
    <?php foreach($model->photos as $photo): ?>
        <li>
            <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(100, 100)), $photo->originalUrl, array('class' => 'image', 'id' => 'user_photo_' . $photo->primaryKey . '_' . $this->id)); ?>
        </li>
    <?php endforeach; ?>
</ul>
