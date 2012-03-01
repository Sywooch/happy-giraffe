<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-mood').delegate('a.pseudo', 'click', function(e) {
            e.preventDefault();
            $('div.moods-list').toggle();
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
                    $('div.user-mood').html(response);
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
            'canUpdate' => true,
        )); ?>
    <?php endif; ?>
    <div class="moods-list">
        <ul>
            <?php $moods = UserMood::model()->findAll(); foreach($moods as $m): ?>
                <li><a href="" onclick="return updateMood(<?php echo $m->id; ?>)"><img src="/images/mood_smiles/mood_smile_<?php echo $m->id; ?>.png" /><?php echo $m->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>