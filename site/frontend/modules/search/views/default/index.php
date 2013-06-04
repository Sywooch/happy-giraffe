Общее количесто результатов: <?=$total?>

<?php foreach ($results as $r): ?>
    <?php $this->render('_row', array('data' => $r)); ?>
<?php endforeach; ?>