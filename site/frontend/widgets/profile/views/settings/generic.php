<?php echo CHtml::beginForm(); ?>
    <?php foreach ($attributes as $name => $a): ?>
        <?php echo CHtml::label($a->label, $name); ?>
        <?php echo $a->input('Settings[' . $name . ']', $box->settings[$name]); ?>
    <?php endforeach; ?>
    <?php echo CHtml::submitButton('Сохранить'); ?>
<?php echo CHtml::endForm(); ?>

