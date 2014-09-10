<?php
/* @var HController $this
 * @var Horoscope[] $models
 */
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl">
                <?php
                if ($this->alias == 'today' && $this->period == 'day')
                {
                    $this->pageTitle = 'Гороскоп на сегодня по знакам зодиака';
                    $this->metaDescription = 'Ежедневный гороскоп по знакам Зодиака. Гороскопы на сегодня, завтра, месяц, год.';
                    echo 'Гороскоп на сегодня по знакам Зодиака';
                    $this->breadcrumbs = array(
                        'Гороскопы',
                    );
                }
                elseif ($this->alias == 'tomorrow' && $this->period == 'day')
                {
                    $this->pageTitle = 'Гороскоп на завтра по знакам зодиака';
                    $this->metaDescription = 'Гороскопы для всех знаков Зодиака на завтра бесплатно';
                    echo 'Гороскоп на завтра';
                    $this->breadcrumbs = array(
                        'Гороскопы' => $this->getUrl(array('alias' => 'today')),
                        'На завтра',
                    );
                }
                elseif ($this->period == 'month')
                {
                    $this->pageTitle = 'Гороскоп на каждый месяц';
                    $this->metaDescription = 'Ежемесячный гороскоп для всех знаков зодиака';
                    echo 'Гороскоп на месяц';
                    $this->breadcrumbs = array(
                        'Гороскопы' => $this->getUrl(array('alias' => 'today')),
                        'На месяц',
                    );
                }
                elseif ($this->period == 'year')
                {
                    $this->pageTitle = 'Гороскоп на 2013 год для всех знаков зодиака';
                    $this->metaDescription = 'Гороскоп на 2013 для всех знаков Зодиака: здоровье, карьера, финансы и личная жизнь';
                    echo 'Гороскоп на 2013 год';
                    $this->breadcrumbs = array(
                        'Гороскопы' => $this->getUrl(array('alias' => 'today')),
                        'На год',
                    );
                }
                ?>
            </h1>
            <div class="wysiwyg-content visible-md-block">
                <?php if ($this->alias == 'today'): ?>
                    <p>Нравится ли вам возможность ежедневно советоваться со звёздами? Наверняка вы не раз читали гороскоп для
                        своего знака Зодиака. Что-то в нём вам казалось смешным, а что-то – полезным. Действительно, в то время как
                        одни считают гороскоп сегодня руководством к действию, другие относятся к нему как к пустой забаве.
                        Наверное, это связано с качеством гороскопа. Оцените работу нашего эксклюзивного астролога – прочитайте, что
                        он написал для вас сегодня, нажав на нужный знак Зодиака.</p>
                <?php endif ?>
            </div>
            <div class="wysiwyg-content visible-md-block">
                <?= ServiceText::getText('horoscope', $this->period == 'day' ? $this->alias : $this->period) ?>
            </div>
            <div class="zodiac-list">
                <?php $this->renderPartial('_zodiac_list'); ?>
            </div>
            <div class="menu-link-simple menu-link-simple__center margin-t40">
                <div class="menu-link-simple_t">Узнайте гороскоп</div>
                <?php $this->renderPartial('_menu'); ?>
            </div>
        </div>
    </div>
</div>

<?php
/*$model = new HoroscopeCompatibility();
$this->renderPartial('/compatibility/_compatibility_form', array('model' => $model, 'showTitle' => true));*/