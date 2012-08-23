<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/duel.js');?>

<div class="box activity-duel">

    <div class="title"><?php if (! Yii::app()->user->isGuest && Yii::app()->user->model->canDuel): ?><a href="/ajax/duelForm/" class="btn btn-orange-small fancy"><span><span>Принять участие</span></span></a><?php endif; ?>Дуэль <span>ДНЯ</span></div>

    <?php if ($question): ?>
        <?php $this->render('_duel', array('question' => $question, 'votes' => true)); ?>
    <?php endif; ?>
</div>