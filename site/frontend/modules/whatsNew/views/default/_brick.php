<?php if (Yii::app()->controller->module !== null && Yii::app()->controller->module->id == 'whatsNew' && $index == 0): ?>
    <?php $this->renderPartial('/_update_message'); ?>
<?php endif; ?>

<?=$data->code?>