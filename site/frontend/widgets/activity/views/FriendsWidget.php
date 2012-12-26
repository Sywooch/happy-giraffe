<div class="box activity-find-friend">

    <div class="title"><?=CHtml::link('Найти ещё', array('/friends/find'))?>Найти <span>друзей</span></div>

    <ul class="clearfix">
        <?php foreach ($friends as $f): ?>
            <?php $this->render('_friend', array('f' => $f, 'full' => true)); ?>
        <?php endforeach; ?>

    </ul>

</div>