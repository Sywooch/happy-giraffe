<?php
/**
 * @var $model Horoscope
 * @var $this LiteController
 */
?><?php $time = strtotime($model->date); ?>
<div class="b-main_cont">
    <div class="b-main_col-article">
        <h1 class="heading-link-xxl">
            <?php
            if ($this->alias == 'today' && $this->period == 'day')
            {
                $this->pageTitle = 'Гороскоп на сегодня ' . $model->zodiacText() . ' для женщин и мужчин - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на сегодня для женщин и мужчин. Обновляется ежедневно!';
                $this->metaCanonical = $this->getUrl(array('alias' => false));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на сегодня';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText(),
                );
            }
            elseif ($this->alias == 'tomorrow')
            {
                $this->pageTitle = 'Гороскоп на завтра ' . $model->zodiacText() . ' для мужчин и женщин - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на завтра для женщин и мужчин. Обновляется ежедневно!';
                $this->metaCanonical = $this->getUrl(array('alias' => false));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на завтра';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    'На завтра'
                );
            }
            elseif ($this->period == 'day')
            {
                $this->pageTitle = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::date('j F Y', $this->date) . ' для женщин и мужчин - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . HDate::date('j F Y', $this->date) . ' для женщин и мужчин. Обновляется ежедневно!';
                echo 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::date('j F Y', $this->date);
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    Yii::app()->format->date($this->date)
                );
            }
            elseif ($this->alias == 'today' && $this->period == 'month')
            {
                $this->pageTitle = 'Гороскоп на каждый месяц ' . $model->zodiacText() . ' - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп на месяц ' . $model->zodiacText() . ' для женщин и мужчин. Обновляется ежемесячно!';
                $this->metaCanonical = $this->getUrl(array('alias' => false));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на месяц';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    'На месяц',
                );
            }
            elseif ($this->period == 'month')
            {
                $date = HDate::ruMonth(date('n', $this->date)) . ' ' . date('Y', $this->date);
                $this->pageTitle = $model->zodiacText() . ' . Гороскоп ' . $model->zodiacText2() . ' на ' . $date . ' года - Веселый Жираф';
                $this->metaDescription = 'Гороскоп для ' . $model->zodiacText2() . ' на ' . $date . ' года';
                echo 'Гороскоп ' . $model->zodiacText2() . ' на ' . $date . ' года';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    $date,
                );
            }
            elseif ($this->period == 'year')
            {
                $this->pageTitle = 'Гороскоп  ' . $model->zodiacText() . '  на ' . date('Y', $this->date) . ' год для женщин и мужчин - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . date('Y', $this->date) . ' год для женщин и мужчин. Познай свою судьбу!';
                if($this->alias)
                    $this->metaCanonical = $this->getUrl(array('alias' => false));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на ' . date('Y', $this->date) . ' год';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    date('Y', $this->date),
                );
            }
            ?>
        </h1>
        <?php
        $this->renderPartial('_' . $this->period . '_one', array('model' => $model));
        ?>

        <!-- Лайки от янжекса-->
        <div class="custom-likes">
            <div class="custom-likes_slogan">Вам понравился гороскоп?
            </div>
            <div class="custom-likes_in">
                <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" data-yasharetype="small" class="yashare-auto-init"></div>
            </div>
        </div>
        <!-- Лайки от янжекса-->

        <div class="menu-link-simple menu-link-simple__center">
            <div class="menu-link-simple_t">Еще <?= $model->zodiacText() ?></div>
            <?php $this->renderPartial('_menu'); ?>
        </div>
        <?php
        if ($this->period == 'day')
        {
            ?>
            <div class="seo-desc wysiwyg-content visible-md-block">
                <?= $model->getText(); ?>
            </div>
            <?php
        }
        ?>
        <!-- Реклама яндекса-->
        <?php $this->renderPartial('//banners/_horoscope'); ?>
        <div class='margin-b40'></div>
    </div>
    <!-- /Основная колонка-->
    <div class="b-main_col-sidebar">
        <!-- Зодиаки-->
        <div class="zodiac-list zodiac-list__sidebar">
            <?php $this->renderPartial('_zodiac_list', array('sidebar' => true)); ?>
        </div>
        <!-- Зодиаки-->
    </div>
</div>
