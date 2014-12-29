<?php

$this->pageTitle = $model->isNewRecord ? 'Добавление записи' : 'Редактирование записи';
// $this->renderPartial('/default/form', compact('model', 'slaveModel', 'json', 'club_id'));
?>

<div class="post-add-page content-cols clearfix">
    <div class="col-23-middle">
        <div class="heading-xl">

            <?php if ($model->type_id == CommunityContent::TYPE_POST): ?>
                <span class="user-add-record_ico user-add-record_ico__article active"></span>
                <?php if ($model->isNewRecord): ?>
                Добавление записи
                <?php else: ?>
                Редактировать запись
                <?php endif ?>
            <?php endif ?>

            <?php if ($model->type_id == CommunityContent::TYPE_PHOTO_POST): ?>
                <span class="user-add-record_ico user-add-record_ico__photo active"></span>
                <?php if ($model->isNewRecord): ?>
                Добавление фотопоста
                <?php else: ?>
                Редактировать фотопост
                <?php endif ?>
            <?php endif ?>

            <?php if ($model->type_id == CommunityContent::TYPE_VIDEO): ?>
                <span class="user-add-record_ico user-add-record_ico__video active"></span>
                <?php if ($model->isNewRecord): ?>
                Добавление видеозаписи
                <?php else: ?>
                Редактировать видеопост
                <?php endif ?>
            <?php endif ?>

            <?php if ($model->type_id == CommunityContent::TYPE_STATUS): ?>
                <span class="user-add-record_ico user-add-record_ico__status active"></span>
                <?php if ($model->isNewRecord): ?>
                Добавление статуса
                <?php else: ?>
                Редактировать статуса
                <?php endif ?>
            <?php endif ?>

        </div>

        <?php

        $this->renderPartial('/default/form', compact('model', 'slaveModel', 'json', 'club_id'));
        ?>
    </div>

    <div class="col-1">
    </div>
</div>
