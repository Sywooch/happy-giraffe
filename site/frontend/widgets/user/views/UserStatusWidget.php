<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-status').delegate('a.pseudo', 'click', function(e) {
            e.preventDefault();
            $('div.status-container').hide();
            $('div.user-status > form').show();
        });

        $('div.user-status').delegate('form', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('div.status-container').html(response);
                    $('div.user-status > form').hide();
                    $('div.user-status > form > textarea[name=text]').val('');
                    $('div.status-container').show();
                }
            });
        });
    ";

    $css = "
        div.user-status > form {
            display: none;
        }
    ";

    $cs
        ->registerScript('UserStatusWidget', $js)
        ->registerCss('UserStatusWidget', $css);
?>

<div class="user-status">
    <div class="status-container">
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
    <?php if ($isMyProfile): ?>
        <?php echo CHtml::beginForm(array('user/createRelated', 'relation' => 'status')); ?>
        <?php echo CHtml::textArea('text'); ?><br/>
        <button class="btn btn-green-small"><span><span>Ок</span></span></button>
        <?php echo CHtml::endForm(); ?>
    <?php endif; ?>
</div>