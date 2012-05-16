<div class="box activity-wannachat">

    <div class="title">Хотят <span>общаться</span></div>

    <?php if ($users): ?>
        <ul>
            <?php foreach ($users as $i => $u): ?>
                <li class="clearfix">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $u)); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Пока никого :(</p>
    <?php endif; ?>

    <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
        <div class="me-too">
            я тоже <?php $this->render('_chatButton'); ?>
        </div>
    <?php endif; ?>

</div>





