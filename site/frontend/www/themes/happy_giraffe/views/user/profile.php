<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerCssFile('/stylesheets/user.css');
?>

<div id="user">

    <div class="header clearfix">
        <div class="user-name">
            <h1>Богоявленский<br/>Александр</h1>
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

                <div class="location"><div class="flag flag-ru"></div> Гаврилов-Ям</div>
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

            <div class="user-interests">

                <div class="box-title">Интересы</div>

                <ul>
                    <li><a href="" style="background:#fff9bc;">Спорт</a></li>
                    <li><a href="" style="background:#bef2b9;">Семья</a></li>
                    <li><a href="" style="background:#bfddff;">Игры</a></li>
                    <li><a href="" style="background:#e5d2f7;">Кулинария</a></li>
                    <li><a href="" style="background:#bfddff;">Педагогика</a></li>
                    <li><a href="" style="background:#ffe4b5;">Авто</a></li>
                    <li><a href="" style="background:#ffe4b5;">Рыбалка</a></li>
                    <li><a href="" style="background:#ccf7ff;">Туризм</a></li>
                </ul>

            </div>



        </div>

        <div class="col-2">

            <div class="user-mood">
                Мое настроение &ndash; <img src="/images/user_mood_01.png" />
            </div>

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

            <?php $this->widget('site.frontend.widgets.user.UserAlbumWidget', array(
                'model' => $user,
            )); ?>

        </div>

        <div class="col-3">

            <div class="user-friends clearfix">

                <div class="box-title">Друзья <a href="">Все друзья (105)</a></div>

                <ul>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                    <li><a href=""><img src="/images/user_friends_img.jpg" /></a></li>
                </ul>

            </div>

            <div class="user-map">

                <div class="box-title">Я живу здесь</div>

                <img src="/images/user_map_img.jpg" />

            </div>

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

            <div class="user-horoscope">

                <div class="actions">
                    <a href="" class="close"></a>
                    <a href="" class="settings"></a>
                </div>

                <div class="clearfix">
                    <div class="img"><img src="/images/user_horoscope_01.png" /></div>
                    <div class="date"><big>Овен</big>(24.12-23.01)</div>
                </div>

                <p><b>21 февраля</b> -  Вы настроены на игривый лад – Вам больше хочется развлекаться, чем работать. Да и работа отвечает Вам взаимностью – дела стоят на месте, приходится возвращаться к, казалось бы, уже решенным вопросам и переделывать многое
                    Вам хотелось бы организовать эффективное взаимодействие в совместных проектах. Однако идеи, которые придут к Вам сегодня, могут оказаться не слишком продуманными. Возможно, Вы еще не владеете всей необходимой информацией, поэтому не торопитесь делиться своими мыслями.s</p>

                <p>Вас могут не правильно понять.
                    Так же торопливы сегодня будут и Ваши чувства. Бурные эмоции могут нахлынуть внезапно. Но не рассчитывайте на полное взаимопонимание партнеров.
                    Вечер лучше провести в одиночестве, посвятив его только себе.</p>

            </div>

        </div>

    </div>

</div>