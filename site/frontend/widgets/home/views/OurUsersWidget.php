<?php
/**
 * @var User[] $users
 */
?><div class="box homepage-parents clearfix">

    <div class="title">Наши <span>мамы и папы</span></div>

    <ul>
        <?php foreach ($users as $user): ?>
            <li><a href="<?=Yii::app()->createUrl('/user/profile', array('user_id' => $user->id))
                ?>" class="ava <?=$user->gender == '1'?'male':'female' ?>"><?php echo CHtml::image($user->getAva()); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php if (Yii::app()->user->isGuest):?>
        <div class="join">
            <a href="#register" class="fancy">Присоединяйтесь!</a>
        </div>
    <?php endif ?>

</div>