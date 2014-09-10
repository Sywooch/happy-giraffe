<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
$this->pageTitle = 'Гороскоп на сегодня по знакам зодиака';
$this->breadcrumbs = array(
    'Гороскопы' => $this->getUrl(array('alias' => 'today')),
    'Гороскоп совместимости',
);
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl">Гороскоп совместимости знаков зодиака</h1>
            <div class="wysiwyg-content clearfix visible-md-block">
                <p>Саша + Маша = любовь? Или такой союз обречен на полное отсутствие взаимопонимания, постоянные ссоры и
                    обиды? Это можно выяснить легко и просто с помощью такой полезной вещи, как гороскоп совместимости
                    знаков зодиака!</p>
            </div>
            <div class="horoscope-compatibility-list">
                <ul class="horoscope-compatibility-list_ul">
                    <?php foreach (Horoscope::model()->zodiac_list as $key => $zodiac): ?>
                        <li class="horoscope-compatibility-list_li">
                            <div class="horoscope-compatibility-list_top">
                                <div class="ico-zodiac ico-zodiac__s">
                                    <div class="ico-zodiac_in ico-zodiac__<?= $key ?>"></div>
                                </div>
                            </div>
                            <div class="menu-link-simple menu-link-simple__col">
                                <ul class="menu-link-simple_ul">
                                    <?php foreach (Horoscope::model()->zodiac_list as $key2 => $zodiac2): ?>
                                        <li class="menu-link-simple_li"><a class="menu-link-simple_a" href="<?= $model->getUrl($key, $key2) ?>"><?= $zodiac ?> - <?= $zodiac2 ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="seo-desc wysiwyg-content visible-md-block">
                <p>Бывает так, что нежно любящие друг друга пары искренне полагают, что гороскоп совместимости знаков
                    зодиака им совсем ни к чему. Но почему бы не узнать, какие подводные камни ожидают ваш союз, когда
                    схлынут потоки страсти? Еще классик говорил о том, что любовная лодка может с легкостью разбиться о
                    быт.</p>
                <p>Любовный гороскоп совместимости расскажет вам:</p>
                <ul>
                    <li>как сохранить свой союз на долгие-долгие годы;</li>
                    <li>как уберечь нежную любовь от испытаний бытом;</li>
                    <li>чем отличается мировоззрение разных знаков зодиака;</li>
                    <li>каковы сильные и слабые стороны вашей второй половинки;</li>
                    <li>как искать компромиссы с представителем того или иного знака зодиака.</li>
                </ul>
                <p>Гороскоп совместимости мужчины и женщины, которым вам предлагает воспользоваться &laquo;Веселый жираф&raquo;,
                    содержит множество подробностей о взаимоотношениях представителей разных зодиакальных знаков. Вам не
                    придется довольствоваться короткими отписками и в очередной раз чувствовать себя обманутыми. Мы
                    подготовили для своих читателей максимум интересной (и полезной!) информации, взятой исключительно из
                    достоверных источников. Получается, что с нашей помощью вы бесплатно получаете профессиональную
                    астрологическую консультацию на совместимость.</p>
            </div>
        </div>
    </div>
</div>
