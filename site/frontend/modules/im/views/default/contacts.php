<?php foreach ($contacts as $contact): ?>
    <?php $this->renderPartial('_contact', compact('contact')); ?>
<?php endforeach; ?>