<?php
/**
 * @var LiteController $this
 */
$this->pageTitle = 'О нас';
?>

<div class="info-about">
    <div class="info-about-quote">
        <div class="info-about-quote__top"><img src="/lite/images/info/quote.png" alt=""></div>
        <div class="info-about-quote__text">Мы мечтаем создать следующее поколение онлайн-коммуникации. Это будет лучший интернет-проект, помогающий личной жизни каждой семьи</div>
        <div class="info-about-quote__who">
            <div class="info-about-quote__wh">
                <div class="info-about-quote__name">Мира Смурков</div>
                <div class="info-about-quote__position">Founder & CEO</div>
            </div><img src="/lite/images/info/ceo.png" alt="" class="info-about-quote__who__img">
        </div>
    </div>
</div>
<div class="info-do">
    <div class="info-do-now green">
        <div class="info-do-now__img"><img src="/lite/images/info/do-feather.png" alt=""></div>
        <div class="info-do-now__numsmall">130 000</div>
        <div class="info-do-now__txtsmall">записей</div>
        <div class="info-do-now__img"><img src="/lite/images/info/do-picture.png" alt=""></div>
        <div class="info-do-now__numsmall">850 000</div>
        <div class="info-do-now__txtsmall">фотографий</div>
        <div class="info-do-now__img"><img src="/lite/images/info/do-buble.png" alt=""></div>
        <div class="info-do-now__numsmall">1 500 000</div>
        <div class="info-do-now__txtsmall">комментариев</div>
    </div>
    <div class="info-do-now orange">
        <div class="info-do-now__title group">Фан-группа</div>
        <div class="info-do-now__img"><img src="/lite/images/info/do-ok.png" alt=""></div>
        <div class="info-do-now__numbig">200 000</div>
        <div><a href="http://ok.ru/happygiraffe" class="info-do-now__numlink">ok.ru/happygiraffe </a></div>
    </div>
    <div class="info-do-now blue">
        <div class="info-do-now__title">Золотой сайт</div>
        <div class="info-do-now__sub">Семья и дом</div>
        <div><img src="/lite/images/info/do-gold.png" alt="" height="300px"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="info-sponsors">
    <div class="info-sponsors-title">Наша команда</div>
    <div class="info-team">
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-1.png" alt=""></div>
            <div class="info-team-member__name">Никита</div>
            <div class="info-team-member__position">CTO+BACK-END</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-2.png" alt=""></div>
            <div class="info-team-member__name">Татьяна</div>
            <div class="info-team-member__position">FINANCIALS</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-4.png" alt=""></div>
            <div class="info-team-member__name">Никита</div>
            <div class="info-team-member__position">FRONT-END</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-3.png" alt=""></div>
            <div class="info-team-member__name">Кирилл</div>
            <div class="info-team-member__position">BACK-END</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-5.png" alt=""></div>
            <div class="info-team-member__name">Александр</div>
            <div class="info-team-member__position">UX+DESIGNER</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-6.png" alt=""></div>
            <div class="info-team-member__name">Елена</div>
            <div class="info-team-member__position">SALES</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-7.png" alt=""></div>
            <div class="info-team-member__name">Жан</div>
            <div class="info-team-member__position">SYSADMIN</div>
        </div>
        <div class="info-team-member">
            <div class="info-team-member__img"><img src="/lite/images/info/team-8.png" alt=""></div>
            <div class="info-team-member__name">Татьяна</div>
            <div class="info-team-member__position">COMMUNITY</div>
        </div>
        <div class="clearfix"></div>
        <div class="info-team-plus"><span class="info-team-plus__plus">+</span><span class="info-team-plus__text">модераторы, редакторы, тестировщики</span></div>
    </div>
</div>
<div class="info-hero info-join">
    <div class="info-join-title">Нас посетило уже!</div>
    <div class="info-join-counter">
        <!--Countdown dashboard start
        -->
        <?php $this->widget('application.widgets.home.CounterWidget'); ?>
        <!--Countdown dashboard end
        -->
    </div>
    <div class="info-join-people">
        <div class="info-join-people__part"><img src="/lite/images/info/father.png" alt=""></div>
        <div class="info-join-people__part center"></div>
        <div class="info-join-people__part"><img src="/lite/images/info/mother.png" alt=""></div>
    </div>
    <div class="info-join-people">
        <div class="info-join-people__part">пап</div>
        <div class="info-join-people__part center">и </div>
        <div class="info-join-people__part">мам</div>
    </div>
    <div class="info-join-button"><a href="#" class="info-form__button big registration-button" data-bind="follow: {}">Присоединяйтесь!</a></div>
</div>