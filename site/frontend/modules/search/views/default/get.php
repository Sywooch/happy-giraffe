<?php
/**
 * @var HActiveRecord[] $results
 */
?>

<?php foreach ($results as $data): ?>
    <?php $this->renderPartial('_row', compact('data')); ?>
<?php endforeach; ?>