<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/userActivity.js')
    ;
?>

<div class="col-1">

    <?php if ($type == 'my'): ?>

        <?php $this->renderPartial('_userinfo', array('user' => $this->user)); ?>

        <div class="user-joined">
            <div class="calendar-date">
                <div class="y"><?=Yii::app()->dateFormatter->format("yyyy", $this->user->register_date)?></div>
                <div class="d"><?=Yii::app()->dateFormatter->format("dd", $this->user->register_date)?></div>
                <div class="m"><?=Yii::app()->dateFormatter->format("MMM", $this->user->register_date)?></div>
            </div>
            <span><?=($this->user->gender == 0)?'Присоединилась':'Присоединился' ?> к «Весёлому Жирафу»</span>
        </div>

    <?php else: ?>

        <?php $this->renderPartial('_friends_sidebar'); ?>

    <?php endif; ?>

</div>

<div class="col-23">

    <div class="content-title-new">
        <?=$title?>
    </div>

    <div id="user-activity"<?php if ($type == 'friends'): ?> class="user-friends-activity"<?php endif; ?>>

        <?php foreach ($actions as $i => $action): ?>

            <?php
                $open = ($i == 0) || ! HDate::isSameDate($actions[$i]->updated, $actions[$i - 1]->updated);
                $close = ($i == (count($actions) - 1)) || ! HDate::isSameDate($actions[$i]->updated, $actions[$i + 1]->updated);
            ?>

            <?php if ($open): ?>
            <div class="clearfix">

                <div class="calendar-date">
                    <div class="y"><?=Yii::app()->dateFormatter->format("yyyy", $action->updated)?></div>
                    <div class="d"><?=Yii::app()->dateFormatter->format("dd", $action->updated)?></div>
                    <div class="m"><?=Yii::app()->dateFormatter->format("MMM", $action->updated)?></div>
                </div>

                <div class="activity-list">
            <?php endif; ?>

                    <?php $this->renderPartial('activity/' . $action->type, compact('action', 'type', 'users')); ?>

            <?php if ($close): ?>
                </div>

            </div>
            <?php endif; ?>

            <?php $i++; ?>
        <?php endforeach; ?>

        <?php if ($nextPage !== false): ?>
            <?php if (isset($allActivity)):?>
                <?=CHtml::link('Что еще нового', array('user/activityAll', 'page' => $nextPage), array('class' => 'more-btn'))?>
            <?php else: ?>
                <?=CHtml::link('Что еще нового', array('user/activity', 'user_id' => $this->user->id, 'type' => $type, 'page' => $nextPage), array('class' => 'more-btn'))?>
            <?php endif ?>
        <?php endif; ?>

    </div>

</div>