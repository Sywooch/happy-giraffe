<div class="ext-links-add">
    <?php if (Yii::app()->user->checkAccess('externalLinks-manager-panel')): ?>
        <?php $this->renderPartial('/forums/sub_menu') ?>
    <?php endif ?>

    <div class="ext-links-add">
        <div class="tasks-count">Норма выполнена или доступных заданий больше нет</div>
    </div>
</div>