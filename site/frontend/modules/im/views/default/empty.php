<div class="no-messages">

    <div class="block-title"><span>У вас 0 новых сообщений</span></div>

    <p>Вы можете сами написать  или нажать кнопку  "Хочу общаться", и вам обязательно кто-нибудь напишет.</p>

    <div class="find-friends">

        <?=CHtml::link('Найти друзей', array('/friends/find'))?>
        <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?> <a href="javascript:void(0)" class="wannachat" onclick="WantToChat.send(this);">Хочу общаться!</a><?php endif; ?>

    </div>

</div>

<?php if ($wantToChat): ?>
    <div class="friends clearfix">

        <div class="block-title"><span>Сейчас хотят общаться</span></div>

        <ul>

            <?php foreach ($wantToChat as $u): ?>
                <li>
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $u,
                        'location' => false,
                        'friendButton' => true,
                    )); ?>
                </li>
            <?php endforeach; ?>

        </ul>

    </div>
<?php endif; ?>

<?php if ($friends): ?>
    <div class="friends clearfix">

        <div class="block-title"><span>Друзья на сайте</span> <?=CHtml::link('Все друзья на сайте', 'javascript:void(0)', array('onclick' => 'Messages.open(null, 3)'))?></div>

        <ul>

            <?php foreach ($friends as $u): ?>
                <li>
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $u,
                        'location' => false,
                        'friendButton' => true,
                    )); ?>
                </li>
            <?php endforeach; ?>

        </ul>

    </div>
<?php endif; ?>