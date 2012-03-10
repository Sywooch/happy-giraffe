<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-purpose').delegate('a.pseudo', 'click', function(e) {
            e.preventDefault();
            $('div.user-purpose > form').toggle();
        });

        $('div.user-purpose').delegate('form', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('div.purpose-container').html(response.html);
                        $('div.user-purpose > form').hide();
                        $('div.user-purpose > form > textarea[name=text]').val('');
                        $('div.user-purpose').removeClass('error');
                    } else {
                        $('div.user-purpose').addClass('error');
                    }
                }
            });
        });
    ";

    $css = "
        div.user-purpose > form {
            display: none;
        }
    ";

    $cs
        ->registerScript('UserPurposeWidget', $js)
        ->registerCss('UserPurposeWidget', $css);
?>

<div class="user-purpose">
    <i class="icon"></i>
    <div class="purpose-container">
        <?php if ($isMyProfile): ?>
            <?php if ($user->purpose === null): ?>
                <span>&nbsp;</span>
                <p><a href="" class="pseudo">Какая Ваша самая главная цель в<br/>настоящее время?</a></p>
            <?php else: ?>
                <?php $this->render('_purpose', array(
                    'purpose' => $user->purpose,
                    'canUpdate' => true,
                )); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php $this->render('_purpose', array(
                'purpose' => $user->purpose,
                'canUpdate' => false,
            )); ?>
        <?php endif; ?>
    </div>
    <?php if ($isMyProfile): ?>
        <?php echo CHtml::beginForm(array('user/createRelated', 'relation' => 'purpose')); ?>
        <?php echo CHtml::textArea('text'); ?><br/>
        <button class="btn btn-green-small"><span><span>Ок</span></span></button>
        <?php echo CHtml::endForm(); ?>
    <?php endif; ?>
</div>
