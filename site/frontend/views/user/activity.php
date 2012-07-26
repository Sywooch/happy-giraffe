<?php
    $cs = Yii::app()->clientScript;
    $cs
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

                <div class="clearfix">

                    <div class="calendar-date">
                        <div class="y"><?=Yii::app()->dateFormatter->format("yyyy", time())?></div>
                        <div class="d"><?=Yii::app()->dateFormatter->format("dd", time())?></div>
                        <div class="m"><?=Yii::app()->dateFormatter->format("MMM", time())?></div>
                    </div>

                    <div class="activity-list">

                        <?php foreach ($actions as $action): ?>
                            <?php $this->renderPartial('activity/' . $action->type, compact('action')); ?>
                        <?php endforeach; ?>

                    </div>

                </div>

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