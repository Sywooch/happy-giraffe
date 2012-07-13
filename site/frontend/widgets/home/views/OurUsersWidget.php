<?php
/**
 * @var User[] $users
 */
?><div class="box homepage-parents clearfix">

    <div class="title">Наши <span>мамы и папы</span></div>

    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php $class = $user->gender == '1'?'male':'female'; $class.= ' ava'; ?>
                <?=HHtml::link(CHtml::image($user->getAva()), Yii::app()->createUrl('/user/profile', array('user_id' => $user->id)), array('class'=>$class), true)?>
        <?php endforeach; ?>
    </ul>

    <?php if (Yii::app()->user->isGuest):?>
        <div class="join">
            <?=CHtml::link('Присоединяйтесь!', '#register', array('class' => 'fancy', 'data-theme'=>'white-square'))?>
        </div>
    <?php endif ?>

</div>