<?php
/**
 * @var LiteController $this
 */
$this->pageTitle = 'О нас';
?>

<div class="info-about">
    <div class="info-about-quote">
        <div class="info-about-quote__top"><img src="/lite/images/info/quote.png" alt=""></div>
        <div class="info-about-quote__text">Мы мечтаем создать следующее поколение онлайн-коммуникации. Это будет лучший интернет-проект, помогающий личной жизни каждой семьи.</div>
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
<div class="info-hero info-join info-last">
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
