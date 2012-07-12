<?php
/**
 * @var User[] $users
 */
?><div class="box homepage-parents clearfix">

    <div class="title">Наши <span>мамы и папы</span></div>

    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?=HHtml::link(CHtml::image($user->getAva()), Yii::app()->createUrl('/user/profile', array('user_id' => $user->id)), array('class'=>'ava '.$user->gender == '1'?'male':'female'), true)?>
        <?php endforeach; ?>
    </ul>

    <?php if (Yii::app()->user->isGuest):?>
        <div class="join">
            <a href="<?= Yii::app()->createUrl('signup/', array()) ?>">Присоединяйтесь!</a>
        </div>
    <?php endif ?>

</div>