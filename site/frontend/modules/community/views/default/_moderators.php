<div class="b-section_transp">
    <h1 class="b-section_transp-t"><?=$community->title ?></h1>

    <div class="b-section_transp-desc"><?=$community->description ?></div>

    <a href="" class="b-section_club-add" data-bind="click: subscribe, visible: !active()">
        <span class="b-section_club-add-tx">Вступить в клуб</span>
    </a>

    <div class="b-section_club-moder" data-bind="visible: active()">
        <span class="b-section_club-moder-tx">Модераторы <br> клуба</span>
        <?php foreach ($moderators as $moderator): ?>
            <?php $this->widget('Avatar', array('user' => $moderator)); ?>
        <?php endforeach; ?>
    </div>
</div>