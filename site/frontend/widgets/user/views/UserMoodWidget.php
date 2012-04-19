<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-mood').delegate('a.pseudo', 'click', function(e) {
            e.preventDefault();
            $('div.moods-list').toggle();
        });

        $('div.user-mood').delegate('#userMood', {
            'mousemove':function(e){
				$('#userMoodTooltip').css({
					left: e.pageX - $('#userMoodTooltip').parents('div.user-mood').offset().left - ($('#userMoodTooltip').innerWidth() / 2), top: e.pageY - $('#userMoodTooltip').parents('div.user-mood').offset().top - ($('#userMoodTooltip').innerHeight() + 10)
				});
			},
			'mouseenter': function(e){
				$('#userMoodTooltip').fadeIn(200);
			},
			'mouseleave': function(e){
				$('#userMoodTooltip').fadeOut(200);
			}
        });
    ";

    $js_head = "
        function updateMood(mood_id)
        {
            $.ajax({
                type: 'POST',
                url: '" . Yii::app()->controller->createUrl('user/updateMood') . "',
                data: {mood_id: mood_id},
                success: function(response) {
                    $('div.mood-container').html(response);
                    $('div.moods-list').hide();
                }
            });
            return false;
        }
    ";

    $css = "
        div.moods-list {
            display: none;
        }
    ";

    $cs
        ->registerScript('UserMoodWidget', $js)
        ->registerScript('UserMoodWidget_head', $js_head, CClientScript::POS_HEAD)
        ->registerCss('UserMoodWidget', $css);
?>

<div class="user-mood">
    <div class="mood-container">
        <?php if ($isMyProfile): ?>
            <?php if ($user->mood === null): ?>
                <a href="" class="pseudo">Какое у Вас настроение?</a>
            <?php else: ?>
                <?php $this->render('_mood', array(
                    'mood' => $user->mood,
                    'canUpdate' => true,
                )); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php $this->render('_mood', array(
                'mood' => $user->mood,
                'canUpdate' => false,
            )); ?>
        <?php endif; ?>
    </div>
    <?php if ($isMyProfile): ?>
        <div class="moods-list">
            <ul>
                <?php $moods = UserMood::model()->findAll(); foreach($moods as $m): ?>
                    <li><a href="" onclick="return updateMood(<?php echo $m->id; ?>)"><img src="/images/widget/mood/<?php echo $m->id; ?>.png" /><?php echo $m->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>