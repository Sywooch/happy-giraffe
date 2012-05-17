<div class="box activity-duel">

    <div class="title"><?php if (! Yii::app()->user->isGuest): ?><a href="/ajax/duelForm/" class="btn btn-orange-small fancy"><span><span>Принять участие</span></span></a><?php endif; ?>Дуэль <span>ДНЯ</span></div>

    <?php if ($question): ?>
        <?php $this->render('_duel', compact('question')); ?>
    <?php endif; ?>
</div>