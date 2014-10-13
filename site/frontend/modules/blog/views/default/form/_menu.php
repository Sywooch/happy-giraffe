<?php if ($model->isNewRecord): ?>
    <div class="user-add-record user-add-record__yellow clearfix">
        <div class="user-add-record_ava-hold">
            <?php $this->widget('Avatar', array('user' => $this->user)); ?>
        </div>
        <div class="user-add-record_hold js_add_menu">
            <div class="user-add-record_tx">Я хочу добавить</div>
            <a href="javascript:void(0)" class="user-add-record_ico user-add-record_ico__article <?php if ($type == 1) echo 'active' ?>" onclick="return AddMenu.select(this, 1, '<?=$club_id ?>', <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>);">Статью</a>
                <?php
                if (Yii::app()->user->checkAccess('advEditor'))
                    echo CHtml::link(
                        'Супер-статью',
                        Yii::app()->createUrl('editorialDepartment/redactor/index', array(
                            'forumId' => $club_id,
                        )),
                        array('class' => 'user-add-record_ico user-add-record_ico__article')
                    );
                ?>
            <a href="javascript:void(0)" class="user-add-record_ico user-add-record_ico__photo <?php if ($type == 3) echo 'active' ?>" onclick="return AddMenu.select(this, 3, '<?=$club_id ?>', <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>);">Фото</a>
            <a href="javascript:void(0)" class="user-add-record_ico user-add-record_ico__video <?php if ($type == 2) echo 'active' ?>" onclick="return AddMenu.select(this, 2, '<?=$club_id ?>', <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>);">Видео</a>
            <?php if (empty($club_id)):?>
                <a href="javascript:void(0)" class="user-add-record_ico user-add-record_ico__status <?php if ($type == 5) echo 'active' ?>" onclick="return AddMenu.select(this, 5, '<?=$club_id ?>', <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>);">Статус</a>
            <?php endif ?>
        </div>
    </div>
<?php endif; ?>