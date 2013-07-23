<div class="b-ava-large">
    <div class="b-ava-large_ava-hold clearfix">
        <a class="ava large" href="<?=$data->url?>">
            <?=CHtml::image($data->getAva('large'))?>
        </a>
        <?php if ($data->online): ?>
            <span class="b-ava-large_online">На сайте</span>
        <?php endif; ?>
        <a href="<?=$data->dialogUrl?>" class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="tooltip: 'Начать диалог'">
            <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
            <span class="b-ava-large_bubble-tx">+5</span>
        </a>
        <a href="<?=$data->photosUrl?>" class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="tooltip: 'Фотографии'">
            <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
            <span class="b-ava-large_bubble-tx">+50</span>
        </a>
        <a href="<?=$data->blogUrl?>" class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="tooltip: 'Записи в блоге'">
            <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
            <span class="b-ava-large_bubble-tx">+999</span>
        </a>
        <a class="b-ava-large_bubble" data-bind="tooltip: tooltipText, css: aCssClass, click: clickHandler">
            <span class="b-ava-large_ico" data-bind="css: spanCssClass"></span>
        </a>
    </div>
    <div class="textalign-c">
        <a href="<?=$data->url?>" class="b-ava-large_a"><?=$data->fullName?></a>
        <?php if ($data->birthday !== null): ?>
            <span class="font-smallest color-gray"> <?=$data->normalizedAge?></span>
        <?php endif; ?>
    </div>
</div>
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