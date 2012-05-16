<div class="box activity-onair">

    <div class="title"><img src="/images/onair_title.png" />Прямой <span>эфир</span></div>

    <ul id="contents_live" class="short">
        <?php foreach ($live as $l): ?>
            <?php $this->render('_live_entry', array('data' => $l)); ?>
        <?php endforeach; ?>
    </ul>

    <div class="all-link"><a href="<?=$this->createUrl('activity/live')?>">Весь прямой эфир</a></div>

</div>