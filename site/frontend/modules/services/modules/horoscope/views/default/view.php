<?php
/**
 * @var $model Horoscope
 */
?><?php $time = strtotime($model->date); ?>
<div class="b-main_col-article">
    <h1 class="heading-link-xxl"><?= $this->title ?></h1>
    <div class="horoscope-day">
        <div class="ico-zodiac ico-zodiac__xl">
            <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
        </div>
        <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
    </div>
    <div class="wysiwyg-content clearfix">
        <?php
        if (Yii::app()->controller->action->id != 'date')
        {
            $this->beginWidget('SeoContentWidget');
            echo Str::strToParagraph($model->text);
            $this->endWidget();
        }
        ?>
        <p><?= $model->getAdditionalText() ?></p>
    </div>
    <!-- Лайки от янжекса-->
    <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>
    <!--<div class="custom-likes">
        <div class="custom-likes_slogan">Вам понравился гороскоп?
        </div>
        <div class="custom-likes_in">
            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
            <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" data-yasharetype="small" class="yashare-auto-init"></div>
        </div>
    </div>-->
    <!-- Лайки от янжекса-->
    <div class="menu-link-simple menu-link-simple__center">
        <div class="menu-link-simple_t">Еще Овен</div>
        <ul class="menu-link-simple_ul">
            <li class="menu-link-simple_li"><a href="#" class="menu-link-simple_a">На завтра</a></li>
            <li class="menu-link-simple_li"><a href="#" class="menu-link-simple_a">На месяц</a></li>
            <li class="menu-link-simple_li"><a href="#" class="menu-link-simple_a">На 2014</a></li>
            <li class="menu-link-simple_li"><a href="#" class="menu-link-simple_a"><span class="color-gray">+ &nbsp;</span>Гороскоп Овна по дням</a></li>
        </ul>
    </div>
    <div class="seo-desc wysiwyg-content visible-md-block">
        <p>Читая гороскоп Овна на сегодня, не забывайте о притче, которая как нельзя лучше подходит для людей этого знака.</p>
        <p>В горном ауле жил мальчик Сиб. Однажды он увидел во сне море. Сиб рассказывал свой сон каждому встречному, но над ним лишь смеялись. Никто в этом ауле не знал, что такое море. Однако мальчика так поразил сон, что, как только он вырос, сразу отправился на поиски приснившегося. Долго он шел и достиг развилки дорог.</p>
        <p>Сиб выбрал правую дорогу и скоро пришёл в небольшой красивый городок, но там тоже никто ничего не знал про море. Городок юноше понравился. Он выучился на башмачника и стал шить лучшие башмаки. Прошло пятнадцать лет. Сиб стал уважаемым человеком и уже подумывал о женитьбе, как вдруг снова увидел сон про море.</p>
        <p>Он вернулся к развилке и выбрал среднюю дорогу. Через два дня пути Сиб дошел до ветхого дома, в котором жила одинокая женщина. Он решил помочь ей восстановить хозяйство, да так и остался жить. Тридцать лет прошли в счастье и согласии, как вдруг Сиб снова увидел свой сон.</p>
        <p>Не медля ни минуты, вернулся он к развилке дорог и теперь пошел по самой левой. Эта дорога вела высоко в горы. Сибу приходилось ползти, цепляясь за камни и растения. Но он, стиснув зубы, продвигался всё дальше.</p>
        <p>Умирающим стариком дополз Сиб до вершины горы. Последний раз поднял он голову и увидел аул, где родился, городок, в котором стал башмачником, дом с любимой женщиной. А за ними раскинулось огромное, блестящее на солнце море. Сиб осознал, что все три дороги вели к морю, только нужно было пройти их до конца.</p>
        <p>Жаль, что Сиб не читал гороскоп Овна на сегодня. Возможно, тогда бы у него был шанс не только увидеть свою мечту, но и в полной мере насладиться ею.</p>
    </div>
    <!-- Реклама яндекса-->
    <?php $this->renderPartial('//banners/_horoscope'); ?>
</div>
<!-- /Основная колонка-->
<div class="b-main_col-sidebar">
    <!-- Зодиаки-->
    <div class="zodiac-list zodiac-list__sidebar">
        <?php $this->renderPartial('_zodiac_list', array('models' => $models)); ?>
    </div>
    <!-- Зодиаки-->
</div><!--
<div class="horoscope-one">

    <div class="block-in">

        <div class="img">

            <div class="in"><img src="/images/widget/horoscope/big/<?= $model->zodiac ?>.png"></div>
            <div class="date"><span><?= $model->zodiacText() ?></span><?= $model->zodiacDates() ?></div>

        </div>

        <div class="dates">
            <?php $this->renderPartial('_forecast_menu', array('model' => $model)) ?>
        </div>

        <div class="text clearfix">
            <div class="date">
                <span><?= date("j", strtotime($model->date)) ?></span>
                <?= HDate::ruMonthShort(date("n", strtotime($model->date))) ?>
            </div>
            <div class="holder">
                <?php if (Yii::app()->controller->action->id != 'date') $this->beginWidget('SeoContentWidget'); ?>
                <?= Str::strToParagraph($model->text) ?>
                <?php if (Yii::app()->controller->action->id != 'date') $this->endWidget(); ?>
                <p><?= $model->getAdditionalText() ?></p>

                <?php if (Yii::app()->controller->action->id == 'date'): ?>
                    <div class="dates clearfix">
                        <?php $prev = strtotime('-1 day', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($prev)): ?>
                            <span class="a-left"><?= $model->getDateLink($prev) ?></span>
                        <?php endif ?>
                        <?php $next = strtotime('+1 day', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($next)): ?>
                            <span class="a-right"><?= $model->getDateLink($next) ?></span>
                        <?php endif ?>


                        <?php $prev = strtotime('-2 days', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($prev)): ?>
                            <span class="a-left"><?= $model->getDateLink($prev) ?></span>
                        <?php endif ?>

                        <?php $next = strtotime('+2 days', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($next)): ?>
                            <span class="a-right"><?= $model->getDateLink($next) ?></span>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if (Yii::app()->controller->action->id == 'yesterday'): ?>
            <div class="horoscope-daylist clearfix">
                <ul>
                    <?php for ($i = 2; $i < 10; $i++): ?>
                        <li><?= $model->getDateLink(strtotime('-' . $i . ' days')) ?></li>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif ?>

        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list', array('model' => $model)); ?>

<?php if (Yii::app()->controller->action->id != 'date'): ?>
    <div class="wysiwyg-content">

        <?= $model->getText(); ?>

    </div>
<?php endif ?>

<div class="horoscope-otherday">
    <?= $model->getDateLinks() ?>
</div>-->
