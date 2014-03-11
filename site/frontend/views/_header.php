<?php if (! Yii::app()->user->isGuest): ?>
    <?php $this->renderPartial('//_menu'); ?>
<?php else: ?>
    <?php $this->renderPartial('//_header_guest'); ?>
<?php endif; ?>