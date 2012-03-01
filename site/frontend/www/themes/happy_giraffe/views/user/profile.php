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
            <div class="online-status online"><i class="icon"></i>Сейчас на сайте</div>
        </div>

        <div class="user-nav">
            <ul>
                <li class="active"><a href="">Анкета</a></li>
                <li><a href="">Блог</a></li>
                <li><a href="">Фото</a></li>
                <li><a href="">Друзья</a></li>
                <li><a href="">Клубы</a></li>
            </ul>
        </div>
    </div>

    <div class="user-cols clearfix">

        <div class="col-1">

            <div class="user-photo">
                <img src="/images/user_profile_img.jpg" />
            </div>

            <div class="user-meta">

                <div class="location"><?php echo $user->getFlag() ?> <?php echo isset($user->settlement)?$user->settlement->name:'' ?></div>
                <span>День рождения:</span> 15 декабря (39 лет)

                <div class="details">
                    Зарегистрирван  25 февраля 2012<br/>
                    Баллов: <span class="rating">12 867</span><br/>
                    Уровень: <span class="rang">Ветеран</span><br/>
                </div>

            </div>

            <div class="user-family">
                <div class="t"></div>
                <div class="c">
                    <ul>
                        <li class="clearfix">
                            <big>Моя жена</big>
                            <div class="img"><a href=""><img src="/images/user_friends_img.jpg" /></a><span>Светлана</span></div>
                            <p>Очень любит готовить, заниматься с детьми</p>
                        </li>
                        <li class="clearfix">
                            <big>Моя дочь</big>
                            <div class="img"><a href=""><img src="/images/user_friends_img.jpg" /></a><span>Иришка, <span>3 года</span></span></div>
                            <p>Очень любит готовить, заниматься с детьми</p>
                        </li>
                        <li class="clearfix">
                            <big>Мой сын</big>
                            <div class="img"><a href=""><img src="/images/user_friends_img.jpg" /></a><span>Артем, <span>10 лет</span></span></div>
                            <p>Очень любит готовить, заниматься с детьми</p>
                        </li>

                    </ul>
                </div>
                <div class="b"></div>
            </div>

            <?php $this->widget('application.widgets.user.InterestsWidget',array('user'=>$user)) ?>

        </div>

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

            <div class="user-blog">

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

            </div>

            <div class="user-clubs clearfix">

                <div class="box-title">Клубы <a href="">Все клубы (105)</a></div>

                <ul>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим и уход Дети до года</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим до года</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Дети до года</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим и уход Дети до и уход Дети до года</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Дети</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим и уход</a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a><a href="">Режим и уход Дети до года</a></li>
                </ul>

            </div>

            <?php $this->widget('site.frontend.widgets.user.UserAlbumWidget', array('user' => $user,)); ?>

        </div>

        <div class="col-3">

            <?php $this->widget('UserFriendsWidget', array(
                'user' => $user,
            )); ?>

            <?php $this->widget('application.widgets.user.LocationWidget',array(
            'user'=>$user)) ?>

            <div class="user-weather">

                <div class="location">
                    <div class="flag flag-ru"></div>Россия<br/>
                    <big>Гаврилов-Ям</big>
                </div>

                <div class="clearfix">

                    <div class="img"><img src="/images/user_weather_01.png" /></div>

                    <div class="text">
                        <big>-16</big>
                        <div class="row hl"><span>Ночью</span>-22</div>
                        <div class="row"><span>Завтра</span>-17</div>
                    </div>

                </div>

                <a href="">Прогноз на неделю</a>

            </div>

            <?php $this->widget('application.widgets.user.HoroscopeWidget',array('user'=>$user)) ?>

        </div>

    </div>
    <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
        'model' => $user,
        'title' => 'Гостевая'
    )); ?>
</div>