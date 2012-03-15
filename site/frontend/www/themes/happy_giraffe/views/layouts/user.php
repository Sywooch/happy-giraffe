<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css');
?>

<div id="user">

    <div class="header clearfix">

        <div class="user-fast">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $this->user)); ?>
        </div>

        <div class="user-nav">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Анкета',
                            'url' => array('user/profile', 'user_id' => $this->user->id),
                        ),
                        array(
                            'label' => 'Блог',
                            'url' => array('user/blog', 'user_id' => $this->user->id),
                        ),
                        array(
                            'label' => 'Фото',
                            'url' => array('albums/user', 'id' => $this->user->id),
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