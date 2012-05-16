<div class="box activity-find-friend">

    <div class="title"><?=CHtml::link('Найти ещё', '/activity/friends')?>Найти <span>друзей</span></div>

    <ul class="clearfix">
        <?php foreach ($friends as $f): ?>
            <?php $this->render('_friend', array('f' => $f)); ?>
        <?php endforeach; ?>

    </ul>

</div>