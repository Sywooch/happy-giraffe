<?php if ($model->isNewRecord): ?>
    <div class="user-add-record user-add-record__yellow clearfix">
        <div class="user-add-record_ava-hold">
            <?php $this->widget('Avatar', array('user' => $this->user)); ?>
        </div>
        <div class="user-add-record_hold js_add_menu">
            <div class="user-add-record_tx">Я хочу добавить</div>
            <a href="<?=$this->createUrl('form', array('type' => 1))?>" class="user-add-record_ico user-add-record_ico__article fancy-top <?php if ($type == 1) echo 'active' ?>">Статью</a>
            <a href="<?=$this->createUrl('form', array('type' => 2))?>" class="user-add-record_ico user-add-record_ico__photo fancy-top <?php if ($type == 3) echo 'active' ?>">Фото</a>
            <a href="<?=$this->createUrl('form', array('type' => 3))?>" class="user-add-record_ico user-add-record_ico__video fancy-top <?php if ($type == 2) echo 'active' ?>">Видео</a>
            <a href="<?=$this->createUrl('form', array('type' => 5))?>" class="user-add-record_ico user-add-record_ico__status fancy-top <?php if ($type == 5) echo 'active' ?>">Статус</a>
        </div>
    </div>
<?php endif; ?>