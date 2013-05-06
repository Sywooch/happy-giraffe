<div class="friends-list_ava-hold clearfix">
    <a href="" class="ava large">
        <?=CHtml::image($data->getAva('large'))?>
    </a>
    <span class="friends-list_online">На сайте</span>
    <a href="" class="friends-list_bubble friends-list_bubble__dialog powertip" title="Начать диалог">
        <span class="friends-list_ico friends-list_ico__mail"></span>
        <span class="friends-list_bubble-tx">+5</span>
    </a>
    <a href="" class="friends-list_bubble friends-list_bubble__photo powertip" title="Фотографии">
        <span class="friends-list_ico friends-list_ico__photo"></span>
        <span class="friends-list_bubble-tx">+50</span>
    </a>
    <a href="" class="friends-list_bubble friends-list_bubble__blog powertip" title="Записи в блоге">
        <span class="friends-list_ico friends-list_ico__blog"></span>
        <span class="friends-list_bubble-tx">+999</span>
    </a>
    <a href="" class="friends-list_bubble friends-list_bubble__friend-add powertip" title="Добавить в друзья">
        <span class="friends-list_ico friends-list_ico__friend-add"></span>
    </a>
</div>
<a href="<?=$data->url?>" class="friends-list_a"><?=$data->fullName?></a>
<?php if ($data->birthday !== null): ?>
    <span class="font-smallest color-gray"> <?=$data->normalizedAge?></span>
<?php endif; ?>
<?php if ($data->address->country_id): ?>
<div class="friends-list_location clearfix">
    <?=$data->address->flag?>
    <?=$data->address->getUserFriendlyLocation()?>
</div>
<?php endif; ?>
<?php if (($data->hasPartner() && ! empty($data->partner->name)) || ! empty($data->babies)): ?>
    <div class="find-friend-famyli">
        <ul class="find-friend-famyli-list">
            <?php if ($data->hasPartner() && ! empty($data->partner->name)): ?>
                <?php $this->renderPartial('_partner', array('user' => $data)); ?>
            <?php endif; ?>
            <?php foreach ($data->babies as $b): ?>
                <?php $this->renderPartial('_baby', array('baby' => $b)); ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>