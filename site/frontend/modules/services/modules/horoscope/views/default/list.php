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
            <h1 class="heading-link-xxl"><?= '' ?></h1>
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