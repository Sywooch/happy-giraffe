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
                $this->metaKeywords = 'Гороскоп на сегодня ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();
                //$this->metaCanonical = $this->getUrl(array('alias' => false));
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
                $this->metaKeywords = 'Гороскоп на завтра ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();
                //$this->metaCanonical = $this->getUrl(array('alias' => false));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на завтра';
                $this->breadcrumbs = array(
                    'Гороскопы' => array('/services/horoscope/default/index'),
                    $model->zodiacText() => $this->getUrl(array('alias' => 'today')),
                    'На завтра'
                );
            }
            elseif ($this->period == 'day')
            {
                $this->pageTitle = 'Гороскоп ' . $model->zodiacText2() . ' на ' . HDate::date('j F Y', $this->date) . ' для женщин и мужчин - Веселый Жираф';
                $this->metaDescription = 'Бесплатный гороскоп ' . $model->zodiacText2() . ' на ' . HDate::date('j F Y', $this->date) . ' для женщин и мужчин. Обновляется ежедневно!';
                $this->metaKeywords = 'Гороскоп ' . $model->zodiacText2() . ' на ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($model->date));
                echo 'Гороскоп ' . $model->zodiacText2() . ' на ' . HDate::date('j F Y', $this->date);
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
                $this->metaKeywords = 'Гороскоп на месяц ' . $model->zodiacText() . ', ежемесячный гороскоп ' . $model->zodiacText();
                //$this->metaCanonical = $this->getUrl(array('alias' => false));
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
                $this->pageTitle = 'Гороскоп ' . $model->zodiacText2() . ' на ' . $date . ' года - Веселый Жираф';
                $this->metaDescription = 'Гороскоп для ' . $model->zodiacText2() . ' на ' . $date . ' года';
                $this->metaKeywords = 'Гороскоп ' . $model->zodiacText() . ', ' . HDate::ruMonth(date('m', $this->date)) . ' ' . date('Y', $this->date);
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
                $this->metaKeywords = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . date('Y', $this->date) . ' год для женщин и мужчин. Познай свою судьбу!';
                //if($this->alias)
                //    $this->metaCanonical = $this->getUrl(array('alias' => false));
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
            <div class="custom-likes_slogan">Вам понравился гороскоп?</div>
            <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'lite' => true)); ?> 
        </div>
        <!-- Лайки от янжекса-->

        <div class="menu-link-simple menu-link-simple__center">
            <div class="menu-link-simple_t">Еще <?= $model->zodiacText() ?></div>
            <?php $this->renderPartial('_menu'); ?>
        </div>
        <?php
        $text = $model->getText();
        if ($this->alias && !empty($text))
        {
            ?>
            <div class="seo-desc wysiwyg-content visible-md-block">
                <?= $text ?>
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
