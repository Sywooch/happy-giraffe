<?php echo CHtml::beginForm(); ?>
    <?php foreach ($attributes as $name => $a): ?>
        <?php echo $a->input('name'); ?>
    <?php endforeach; ?>
<?php echo CHtml::endForm(); ?>