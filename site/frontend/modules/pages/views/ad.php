<?php
/**
 * @var LiteController $this
 */
$this->pageTitle = 'Реклама';
?>

<div class="info-ad">
    <div class="info-ad-master">за последний месяц</div>
    <div class="info-ad-part">
        <div class="info-ad-part__img"><img src="/lite/images/info/family.png" alt=""></div>
        <div class="info-ad-part__non">Нас посетило</div>
        <div class="info-ad-part__number">3 647 127</div>
        <div class="info-ad-part__non">будущих и настоящих мам и пап</div>
    </div>
    <div class="info-ad-part">
        <div class="info-ad-part__img"><img src="/lite/images/info/eye.png" alt="" class="eye"></div>
        <div class="info-ad-part__non">Они просмотрели</div>
        <div class="info-ad-part__number">8 922 458</div>
        <div class="info-ad-part__non">страниц сайта</div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="info-sponsors">
    <div class="info-sponsors-title">Наши рекламодатели</div>
    <div class="info-sponsors-img"><img src="/lite/images/info/sponsors.png" alt=""></div>
</div>
<div class="info-hero">
    <div class="info-media-block">
        <div class="info-media-block__part">
            <div class="text-center"><img src="/lite/images/info/media-kit.png" alt=""></div>
        </div>
        <div class="info-media-block__part info-hero__media text-center">
            <div class="info-form-title">Наш медиакит</div>
            <div class="info-form-ms text-center"><a href="/adv/media/happy-giraffe-2015-03.pdf" class="info-form__button">Скачать</a></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="info-clients">
    <div class="info-clients-part">
        <div class="info-clients-part__for yellow">для рекламных агентств</div>
        <div class="info-clients-part__img"><img src="/lite/images/info/people-1.png" alt=""></div>
        <div class="info-clients-part__name">Мира Смурков</div>
        <div class="info-clients-part__link"><a href="mailto:mira@happy-giraffe.ru">mira@happy-giraffe.ru</a></div>
    </div>
    <div class="info-clients-part">
        <div class="info-clients-part__for blue">для прямых клиентов</div>
        <div class="info-clients-part__img"> <img src="/lite/images/info/people-2.png" alt=""></div>
        <div class="info-clients-part__name">Елена Горбунова</div>
        <div class="info-clients-part__link"><a href="mailto:elena@happy-giraffe.ru">elena@happy-giraffe.ru</a></div>
    </div>
    <div class="info-clients-part">
        <div class="info-clients-part__for purple">по финансовым вопросам </div>
        <div class="info-clients-part__img"><img src="/lite/images/info/people-3.png" alt=""></div>
        <div class="info-clients-part__name">Татьяна Тешабаева</div>
        <div class="info-clients-part__link"><a href="mailto:tatyana@happy-giraffe.ru">tatyana@happy-giraffe.ru</a></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="info-want">
    <div class="info-hero-line main">Вы хотите у нас рекламироваться?</div>
    <div class="info-hero-line"><a href="mailto:info@happy-giraffe.ru" class="info-hero-line__mail orange">info@happy-giraffe.ru</a></div>
    <div class="info-want-or">или    </div>
</div>
<?php $this->widget('site\frontend\modules\pages\widgets\contactFormWidget\ContactFormWidget'); ?>