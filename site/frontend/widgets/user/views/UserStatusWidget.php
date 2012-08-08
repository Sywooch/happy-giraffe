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
                dataType: 'JSON',
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('div.status-container').html(response.html);
                        $('div.user-status > form').hide();
                        $('div.user-status > form > textarea[name=text]').val('');
                        $('div.status-container').show();
                        $('div.user-status').removeClass('error');
                    } else {
                        $('div.user-status').addClass('error');
                    }
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

<div class="user-status<?php if ($user->getScores()->full != 2 && $user->id == Yii::app()->user->id) echo ' toggled' ?>">
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