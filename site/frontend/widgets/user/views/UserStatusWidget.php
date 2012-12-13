<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('div.user-status').delegate('a.updateStatus', 'click', function(e) {
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

    $statusStyle = UserAttributes::get($user->id, 'statusStyle', 0);
?>

<div class="user-status<?php if ($statusStyle != 0): ?> pattern<?php endif; ?> pattern-<?=$statusStyle?><?php if ($user->score->full != 2 && $user->id == Yii::app()->user->id) echo ' toggled' ?>" data-style="<?=$statusStyle?>">
    <div class="status-container">
        <?php if ($isMyProfile): ?>
            <?php if ($user->status === null): ?>
                <p><a href="" class="pseudo updateStatus">Что бы Вы хотели всем сообщить?</a></p>
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

<?php if ($this->isMyProfile && $user->hasFeature(2)): ?>
    <div class="user-status-patterns" style="display: none;">
        <p>Выберите подходящий вам стиль</p>
        <ul class="pattern-list clearfix">
            <?php for ($i = 0; $i <= 18; ($i == 0) ? $i = 10 : $i++): ?>
                <li><a href="javascript:void(0)" onclick="Features.selectFeature('statusStyle', <?=$i?>, function(){Features.statusStyle(<?=$i?>)})"<?php if ($statusStyle == $i): ?> class="active"<?php endif; ?>><span class="pattern pattern-<?=$i?>"></span></a></li>
            <?php endfor; ?>
        </ul>
    </div>
<?php endif; ?>