<?php
    $usersIds = array();
    foreach ($action->data as $user)
        $usersIds[] = $user['id'];

    $criteria = new CDbCriteria;
    $criteria->addInCondition('id', $usersIds);
    $users = User::model()->findAll($criteria);
?>

<?php if (! empty($users)): ?>
    <div class="user-friends clearfix list-item">

        <div class="box-title">Новые друзья</div>

        <ul class="clearfix">
            <?php foreach ($users as $user): ?>
                <li>
                    <?php $class = $user->gender == '1'?'male':'female'; $class.= ' ava'; ?>
                    <?=HHtml::link(CHtml::image($user->getAva()), Yii::app()->createUrl('/user/profile', array('user_id' => $user->id)), array('class'=>$class), true)?>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
<?php endif; ?>