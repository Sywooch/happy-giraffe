<?php
/**
 * @var \site\frontend\modules\specialists\models\sub\Common $models
 */
?>

<div class="user-settings_hold">
    <?php foreach ($models as $model): ?>
    <div class="user-settings_row">
        <div class="user-settings_col-label">
            <div class="form-edit_tx"><?=$model->years?></div>
        </div>
        <div class="user-settings_col-inp">
            <div class="form-edit_tx lh-20"><?=$model->place?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
