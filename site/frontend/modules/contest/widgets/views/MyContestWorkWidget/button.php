<?php if (Yii::app()->user->isGuest): ?>
    <a href="#login" class="contest-button fancy">Принять участие!</a>
<?php else: ?>
    <a href="<?=Yii::app()->controller->createUrl('/contest/default/statement', array('id' => $this->contestId))?>" class="contest-button">Принять участие!</a>
<?php endif; ?>