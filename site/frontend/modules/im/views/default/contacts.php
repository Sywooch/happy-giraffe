<?php foreach ($contacts as $c): ?>
    <?php $this->renderPartial('_contact', compact($c)); ?>
<?php endforeach; ?>