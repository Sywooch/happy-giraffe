<?php
    $cs = Yii::app()->clientScript;

$js = <<<EOD
    $(function(){

      $('.activity-list').each(function(){
        $(this).imagesLoaded(function(){
          $(this).masonry({
              itemSelector : $(this).find('.list-item'),
              columnWidth: 360
          });
        })
      })

    })
EOD;

    $cs
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerCssFile('/stylesheets/user.css')
        ->registerScript('user-activity', $js);
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
                            <div class="y"><?=Yii::app()->dateFormatter->format("yyyy", time())?></div>
                            <div class="d"><?=Yii::app()->dateFormatter->format("dd", time())?></div>
                            <div class="m"><?=Yii::app()->dateFormatter->format("MMM", time())?></div>
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