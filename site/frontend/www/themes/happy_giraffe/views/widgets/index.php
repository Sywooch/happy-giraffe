<?php foreach ($widgets as $w): ?>
    <?php echo CHtml::link($w->title, array('add', 'widget_id' => $w->primaryKey)); ?>
<?php endforeach; ?>