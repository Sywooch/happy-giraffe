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
            <?php if($this->withMail) echo $user->getDialogLink(); ?>
            <?php if ($user->online): ?>
                <div class="online-status online"><i class="icon"></i>Сейчас на сайте</div>
            <?php else: ?>
                <div class="online-status offline"><i class="icon"></i>Был на сайте <span class="date"><?php echo HDate::GetFormattedTime($user->login_date); ?></span></div>
            <?php endif; ?>
        </div>

        <div class="user-nav">
            <ul>
                <li class="active"><?php echo CHtml::link('Анкета', array('user/profile', 'user_id' => $user->id)); ?></li>
                <!--<li><a href="">Блог</a></li>-->
                <li><?php echo CHtml::link('Фото', array('albums/user', 'id' => $user->id)); ?></li>
                <!--<li><a href="">Друзья</a></li>-->
                <!--<li><a href="">Клубы</a></li>-->
            </ul>
        </div>
    </div>

    <div class="user-cols clearfix">

        <div class="col-1">

            <div class="user-photo">
                <?php if ($user->id == Yii::app()->user->getId()):?>
                <a href="<?php echo Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>Yii::app()->user->getId()))))) ?>">
                    <img src="<?php echo $user->pic_small->getUrl('bigAva'); ?>" />
                </a>
                <?php else: ?>
                    <img src="<?php echo $user->pic_small->getUrl('bigAva'); ?>" />
                <?php endif ?>
            </div>

            <div class="user-meta">

                <div class="location"><?php echo $user->getFlag() ?> <?php echo isset($user->settlement)?$user->settlement->name:'' ?></div>
                <?php if ($user->birthday): ?><span>День рождения:</span> <?php echo Yii::app()->dateFormatter->format("dd MMMM", $user->birthday); ?> (<?php echo $user->age . ' ' . $user->ageSuffix; ?>)<?php endif; ?>

                <div class="details">
                    Зарегистрирован  <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $user->register_date); ?><br/>
                    <!--Баллов: <span class="rating">12 867</span><br/>
                    Уровень: <span class="rang">Ветеран</span><br/>-->
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

                    <!--<div class="user-blog">

                        <div class="box-title">Блог <a href="">Все записи (25)</a></div>

                        <ul>
                            <li>
                                <a href="">Профилактика атопического дерматита</a>
                                <div class="date">3 сентября 2011, 08:25</div>
                                <p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке...</p>
                            </li>
                            <li>
                                <a href="">Профилактика атопического дерматита</a>
                                <div class="date">3 сентября 2011, 08:25</div>
                                <p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке...</p>
                            </li>
                            <li>
                                <a href="">Профилактика атопического дерматита</a>
                                <div class="date">3 сентября 2011, 08:25</div>
                                <p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке...</p>
                            </li>
                            <li>
                                <a href="">Профилактика атопического дерматита</a>
                                <div class="date">3 сентября 2011, 08:25</div>
                                <p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке...</p>
                            </li>

                        </ul>

                    </div>-->

                    <div class="user-clubs clearfix">

                        <div class="box-title">Клубы <a href="">Все клубы (6)</a></div>

                        <?php $clubs = Community::model()->findAll(array('order' => 'id DESC', 'limit' => 6, 'offset' => 1)); ?>

                        <ul>
                            <?php foreach ($clubs as $c): ?>
                                <li><?php echo CHtml::link(CHtml::image('/images/community/' . $c->id . '_small.png'), array('community/list', 'community_id' => $c->id)); ?><?php echo CHtml::link($c->name, array('community/list', 'community_id' => $c->id)); ?></li>
                            <?php endforeach; ?>
                        </ul>

                    </div>

                    <?php $this->widget('UserAlbumWidget', array('user' => $user,)); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('UserFriendsWidget', array(
                        'user' => $user,
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
                'title' => 'Гостевая'
            )); ?>
        </div>

    </div>

</div>