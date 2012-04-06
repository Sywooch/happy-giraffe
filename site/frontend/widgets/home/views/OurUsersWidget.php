<?php
/**
 * @var User[] $users
 */
?><div class="box homepage-parents clearfix">

    <div class="title"><span>Наши</span> мамы и папы</div>

    <ul>
        <?php foreach ($users as $user): ?>
            <li><a href="<?=Yii::app()->createUrl('/user/profile', array('user_id' => $user->id))
                ?>" class="ava <?=$user->gender == '1'?'male':'female' ?>"><?php echo CHtml::image($user->getAva()); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="join">
        <a href="">Присоединяйтесь!</a>
    </div>

</div>