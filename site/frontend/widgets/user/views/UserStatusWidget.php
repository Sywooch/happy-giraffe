<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-status').delegate('a.pseudo', 'click', function(e) {
            e.preventDefault();
            $('div.user-status').html($('#user-status-form').html());
        });

        $('div.user-status').delegate('form', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('div.user-status').html(response);
                }
            });
        });
    ";

    $css = "
        #user-status-form {
            display: none;
        }
    ";

    $cs
        ->registerScript('UserStatusWidget', $js)
        ->registerCss('UserStatusWidget', $css);
?>

<div class="user-status">
    <?php if ($isMyProfile): ?>
        <?php if ($user->status === null): ?>
            <p><a href="" class="pseudo">Что бы Вы хотели всем сообщить?</a></p>
        <?php else: ?>
            <?php $this->render('_status', array(
                'status' => $user->status,
                'canUpdate' => true,
            )); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php $this->render('_status', array(
            'status' => $user->status,
            'canUpdate' => false,
        )); ?>
    <?php endif; ?>
</div>

<div id="user-status-form">
    <?php echo CHtml::beginForm(array('user/createRelated', 'relation' => 'status')); ?>
    <?php echo CHtml::textArea('text'); ?><br/>
    <button class="btn btn-green-small"><span><span>Ок</span></span></button>
    <?php echo CHtml::endForm(); ?>
</div>