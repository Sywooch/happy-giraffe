Общее количесто результатов: <?=$total?>

<?php foreach ($results as $r): ?>
    <?php $this->renderPartial('_row', array('data' => $r)); ?>
<?php endforeach; ?>