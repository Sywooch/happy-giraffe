<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/userActivity.js')
        ->registerCssFile('/stylesheets/user.css')
    ;
?>

<div id="user">

    <div class="main">
        <div class="main-in">

            <div class="content-title-new">
                Что нового
            </div>

            <div id="user-activity">

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

                            <?php $this->renderPartial('activity/' . $action->type, compact('action')); ?>

                    <?php if ($close): ?>
                        </div>

                    </div>
                    <?php endif; ?>

                    <?php $i++; ?>
                <?php endforeach; ?>

                <?php if ($nextPage !== false): ?>
                    <?=CHtml::link('Что еще нового', array('user/activity', 'user_id' => $this->user->id, 'page' => $nextPage), array('class' => 'more-btn'))?>
                <?php endif; ?>

            </div>

        </div>
    </div>

    <div class="side-left">

        <div class="clearfix user-info-big">
            <div class="user-info">
                <?php
                $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $this->user,
                    'location' => false,
                    'friendButton' => true,
                    'nav' => true,
                    'status' => true,
                ));
                ?>
            </div>
        </div>

        <div class="user-joined">
            <div class="calendar-date">
                <div class="y"><?=Yii::app()->dateFormatter->format("yyyy", $this->user->register_date)?></div>
                <div class="d"><?=Yii::app()->dateFormatter->format("dd", $this->user->register_date)?></div>
                <div class="m"><?=Yii::app()->dateFormatter->format("MMM", $this->user->register_date)?></div>
            </div>
            <span>Присоединился к «Весёлому Жирафу»</span>
        </div>

    </div>

</div>