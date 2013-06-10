<div class="box homepage-parents clearfix">

    <div class="title">Наши <span>мамы и папы</span></div>

    <?php if($this->beginCache('site-users', array('duration'=>300))) { ?>
    <ul>
        <?php
        $criteria = new CDbCriteria(array(
            'select' => 't.id, t.gender, t.first_name, t.last_name, t.avatar_id,
                         count(community__contents.id) AS postsCount,
                         count(album__albums.id) AS albumsCount',
            'having' => 'postsCount > 1 AND albumsCount > 0',
            'group' => 't.id',
            'condition' => 't.birthday IS NOT NULL
                AND address.country_id IS NOT NULL
                AND t.avatar_id IS NOT NULL
                AND email_confirmed = 1',
            'join' => 'LEFT JOIN community__contents ON community__contents.author_id = t.id
                       LEFT JOIN album__albums ON album__albums.author_id = t.id AND type=0',
            'with'=>array(
                'avatar',
                'address',
            ),
            'limit'=>15,
            'order'=>'rand()',
        ));
        $users = User::model()->active()->findAll($criteria);
        ?>
        <?php foreach ($users as $user): ?>
            <li>
                <?php $class = $user->gender == '1'?'male':'female'; $class.= ' ava'; ?>
                <?=HHtml::link(CHtml::image($user->getAva()), Yii::app()->createUrl('/user/profile', array('user_id' => $user->id)), array('class'=>$class), true)?>
        <?php endforeach; ?>
    </ul>
    <?php $this->endCache(); } ?>

    <?php if (Yii::app()->user->isGuest):?>
        <div class="join">
            <?=CHtml::link('Присоединяйтесь!', '#register', array('class' => 'fancy', 'data-theme'=>'white-square'))?>
        </div>
    <?php endif ?>

</div>