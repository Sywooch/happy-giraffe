<?php
/* @var $this Controller
 * @var $user User
 */
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css');
?>
<div id="user">
    <div class="header clearfix">
        <div class="user-name">
            <h1><?php echo $user->first_name . ' ' . $user->last_name; ?></h1>
            <?php echo $user->getDialogLink(); ?>
            <?php if (! Yii::app()->user->isGuest && $user->id != Yii::app()->user->id): ?>
                <?php if ($user->isFriend(Yii::app()->user->id)): ?>
                    Вы друзья.
                <?php else: ?>
                    <?php echo CHtml::link('добавить', array('friendRequests/send', 'to_id' => $user->id)); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($user->online): ?>
                <div class="online-status online"><i class="icon"></i>Сейчас на сайте</div>
            <?php else: ?>
                <div class="online-status offline"><i class="icon"></i>Был на сайте <span class="date"><?php echo HDate::GetFormattedTime($user->login_date); ?></span></div>
            <?php endif; ?>
        </div>

        <div class="user-nav">
            <ul>
                <li class="active"><?php echo CHtml::link('Анкета', array('user/profile', 'user_id' => $user->id)); ?></li>
                <li><?php echo CHtml::link('Блог', array('user/blog', 'user_id' => $user->id)); ?></li>
                <li><?php echo CHtml::link('Фото', array('albums/user', 'id' => $user->id)); ?></li>
                <li><?php echo CHtml::link('Друзья', array('user/friends', 'user_id' => $user->id)); ?></li>
                <li><?php echo CHtml::link('Клубы', array('user/clubs', 'user_id' => $user->id)); ?></li>
            </ul>
        </div>
    </div>

    <div class="user-cols clearfix">

        <div class="col-1">

            <div class="user-photo">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $user, 'size'=>'big', 'small' => true)); ?>
            </div>

            <div class="user-meta">

                <div class="location"><?php echo $user->getFlag() ?> <?php echo isset($user->settlement)?$user->settlement->name:'' ?></div>
                <?php if ($user->birthday): ?><span>День рождения:</span> <?php echo Yii::app()->dateFormatter->format("dd MMMM", $user->birthday); ?> (<?php echo $user->age . ' ' . $user->ageSuffix; ?>)<?php endif; ?>

                <div class="details">
                    Зарегистрирован  <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $user->register_date); ?><br/>
                    Баллов: <span class="rating"><?= $user->getScores()->scores ?></span><br/>
                    Уровень: <span class="rang">Новичок</span><br/>
                </div>

            </div>

            <?php $this->widget('application.widgets.user.FamilyWidget',array('user'=>$user)) ?>

            <?php $this->widget('application.widgets.user.InterestsWidget',array('user'=>$user)) ?>

        </div>
        <div class="col-23 clearfix">
            <div class="clearfix">
                <div class="col-2">

                    <?php $this->widget('UserMoodWidget', array(
                    'user' => $user,
                )); ?>

                    <?php $this->widget('UserStatusWidget', array(
                        'user' => $user,
                    )); ?>

                    <?php $this->widget('UserPurposeWidget', array(
                        'user' => $user,
                    )); ?>

                    <?php $this->widget('BlogWidget', array(
                        'user' => $user,
                    )); ?>

                    <?php $this->widget('UserCommunitiesWidget', array(
                        'user' => $user
                    )); ?>

                    <?php $this->widget('UserAlbumWidget', array('user' => $user,)); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('UserFriendsWidget', array(
                        'user' => $user,
                        'limit' => 8,
                    )); ?>

                    <?php $this->widget('LocationWidget',array(
                    'user'=>$user)) ?>

                    <?php $this->widget('WeatherWidget',array(
                    'user'=>$user)) ?>

                    <?php $this->widget('HoroscopeWidget',array('user'=>$user)) ?>

                </div>
            </div>
            <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
                'model' => $user,
                'title' => 'Гостевая',
                'actions' => false,
            )); ?>
        </div>

    </div>

</div>