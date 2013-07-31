<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css?2');
?>

<div id="user">

    <div class="header clearfix<?php if (Yii::app()->controller->action->id == 'profile') echo ' user-home' ?>">

        <div class="user-fast">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $this->user)); ?>
        </div>

        <div class="user-nav default-nav"">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Анкета',
                            'url' => array('profile/default/index', 'user_id' => $this->user->id),
                        ),
                        array(
                            'label' => 'Семья',
                            'visible' => $this->user->id == Yii::app()->user->id,
                            'url' => array('/family'),
                            'active' => Yii::app()->controller->id == 'family'
                        ),
                        array(
                            'label' => 'Блог',
                            'url' => $this->user->blogPostsCount > 0 ? array('/blog/list', 'user_id' => $this->user->id) : array('/blog/empty'),
                            'active' => Yii::app()->controller->id == 'blog',
                            'visible' => $this->user->blogPostsCount > 0 || $this->user->id == Yii::app()->user->id,
                        ),
                        array(
                            'label' => 'Фото',
                            'url' => array('albums/user', 'id' => $this->user->id),
                            'active' => Yii::app()->controller->id == 'albums'
                        ),
                        array(
                            'label' => 'Друзья',
                            'url' => array('user/friends', 'user_id' => $this->user->id),
                            'active' => $this->action->id == 'friends' || $this->action->id == 'myFriendRequests',
                        ),
                        array(
                            'label' => 'Клубы',
                            'url' => array('user/clubs', 'user_id' => $this->user->id),
                        ),
                    ),
                ));
            ?>
        </div>

    </div>

    <?php echo $content; ?>

</div>

<?php $this->endContent(); ?>