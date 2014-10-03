<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<?php if ($form->multiple): ?>
    <?php $this->renderPartial('_fromComputerMultiple', compact('form')); ?>
<?php else: ?>
    <?php $this->renderPartial('_fromComputerSingle', compact('form')); ?>
<?php endif; ?>