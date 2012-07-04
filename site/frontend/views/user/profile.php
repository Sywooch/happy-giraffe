<?php
/* @var $this Controller
 * @var $user User
 */
    $cs = Yii::app()->clientScript;
    $cs
        ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jscrollpane.min.js')
        ->registerCssFile('/stylesheets/user.css');

    $score = $user->scores;
?>
<div id="user">

    <div class="header clearfix user-home">

        <div class="user-name">
            <h1><?php echo CHtml::encode($user->last_name); ?><br/><?php echo CHtml::encode($user->first_name); ?></h1>
            <?php if ($user->online): ?>
                <div class="online-status online"><i class="icon"></i>Сейчас на сайте</div>
            <?php else: ?>
                <div class="online-status offline"><i class="icon"></i>Был на сайте <span class="date"><?php echo HDate::GetFormattedTime($user->login_date); ?></span></div>
            <?php endif; ?>
            <div class="location">
                <?php if ($user->getUserAddress()->hasCity()): ?>
                    <?=$user->getUserAddress()->getFlag(true)?><?= $user->getUserAddress()->cityName ?>
                <?php endif; ?>
            </div>
            <?php if ($user->birthday): ?><div class="birthday"><span>День рождения:</span> <?=Yii::app()->dateFormatter->format("d MMMM", $user->birthday)?> (<?=$user->normalizedAge?>)</div><?php endif; ?>
        </div>

        <?php if ($user->id != Yii::app()->user->id): ?>
            <div class="user-buttons clearfix">
                <?php
                $this->renderPartial('_friend_button', array(
                    'user' => $user,
                ));
                Yii::app()->controller->renderPartial('_dialog_button', array(
                    'user' => $this->user,
                ));
                $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $user));
                ?>
            </div>
        <?php elseif(Yii::app()->user->checkAccess('manageFavourites')): ?>
            <div class="user-buttons clearfix">
                <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $user)); ?>
            </div>
        <?php endif; ?>

        <div class="user-nav default-nav"">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Анкета',
                            'url' => array('user/profile', 'user_id' => $this->user->id),
                        ),
                        array(
                            'label' => 'Семья',
                            'visible' => $this->user->id == Yii::app()->user->id,
                            'url' => array('/family'),
                        ),
                        array(
                            'label' => 'Блог',
                            'url' => $this->user->blogPostsCount > 0 ? array('/blog/list', 'user_id' => $this->user->id) : array('/blog/empty'),
                            'visible' => $this->user->blogPostsCount > 0 || $this->user->id == Yii::app()->user->id,
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

    <div class="user-cols clearfix">

        <div class="col-1">
            <?php
                $htmlOptions['class'] = 'ava big ' . (($user->gender == 1) ? 'male' : 'female');
                if ($user->getAva('big')) $htmlOptions['class'] .= ' filled';
                if ($user->id == Yii::app()->user->id) $htmlOptions['id'] = 'change_ava';
            ?>
            <?=CHtml::openTag('div', $htmlOptions)?>
                <?php if ($user->id == Yii::app()->user->id): ?>
                    <?php
                        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                            'model' => $user,
                            'id' => 'attach' . get_class($user) . $user->primaryKey,
                        ));
                        $fileAttach->button();
                        $this->endWidget();
                    ?>
                <?php endif; ?>
                <?php if ($user->getAva('big')): ?>
                    <?=CHtml::image($user->getAva('big'), CHtml::encode($user->fullName))?>
                    <?php if ($user->id == Yii::app()->user->id): ?>
                        <a class="renew">Обновить<br>фото</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?=CHtml::closeTag('div')?>

            <div class="details">
                Зарегистрирован <?=Yii::app()->dateFormatter->format("dd MMMM yyyy", $user->register_date)?>
            </div>

            <?php if (!empty($user->getScores()->level_id)): ?>
                <div class="user-lvl user-lvl-<?=$user->getScores()->level_id?>"></div>
            <?php else: ?>
                <div class="user-lvl user-lvl-0"></div>
            <?php endif; ?>

            <?php $this->widget('FamilyWidget', array(
                'user' => $user,
            )); ?>

            <?php $this->widget('InterestsWidget', array(
                'user' => $user,
            )); ?>

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

                    <?php $this->widget('UserAlbumWidget', array(
                        'user' => $user,
                    )); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('UserFriendsWidget', array(
                        'user' => $user,
                    )); ?>

                    <div id="loc-flipbox">
                        <?php $this->widget('LocationWidget', array(
                            'user' => $user,
                        )); ?>
                    </div>

                    <div class="weather-wrapper">
                        <?php $this->widget('WeatherWidget', array(
                            'user' => $user,
                        )); ?>
                    </div>

                    <?php $this->widget('HoroscopeWidget', array(
                        'user' => $user,
                    )); ?>

                    <?php $this->widget('UserDuelWidget', array(
                        'user' => $user,
                    )); ?>

                </div>

            </div>

            <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
                'model' => $user,
                'type' => 'guestBook',
                'title' => 'Гостевая',
                'button' => 'Добавить запись',
                'actions' => false,
            )); ?>

        </div>

    </div>

</div>

<?php if(!Yii::app()->user->isGuest): ?>
    <div style="display: none;">
        <div class="upload-btn" id="refresh_upload">
            <?php
            $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                'model' => new PhotoComment(),
            ));
            $fileAttach->button();
            $this->endWidget();
            ?>
        </div>
    </div>
    <script type="text/javascript">
        var attach_comment_obj = comment_<?php echo get_class($user) . $user->primaryKey; ?>;
    </script>
<?php endif; ?>

<?php
    $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
?>