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
            <h1 class="heading-link-xxl"><?= $this->title ?></h1>
            <div class="wysiwyg-content visible-md-block">
                <?php if (Yii::app()->controller->action->id == 'index'): ?>
                    <p>Нравится ли вам возможность ежедневно советоваться со звёздами? Наверняка вы не раз читали гороскоп для
                        своего знака Зодиака. Что-то в нём вам казалось смешным, а что-то – полезным. Действительно, в то время как
                        одни считают гороскоп сегодня руководством к действию, другие относятся к нему как к пустой забаве.
                        Наверное, это связано с качеством гороскопа. Оцените работу нашего эксклюзивного астролога – прочитайте, что
                        он написал для вас сегодня, нажав на нужный знак Зодиака.</p>
                <?php endif ?>
            </div>
            <div class="wysiwyg-content visible-md-block">
                <?= ServiceText::getText('horoscope', $models[0]->getType()) ?>
            </div>
            <div class="zodiac-list">
            <?php $this->renderPartial('_zodiac_list', array('models' => $models)); ?>
            </div>
            <div class="menu-link-simple menu-link-simple__center margin-t40">
                <div class="menu-link-simple_t">Узнайте гороскоп</div>
                <?php
                $this->widget('HMenu', array(
                    'itemCssClass' => 'menu-link-simple_li',
                    'htmlOptions' => array('class' => 'menu-link-simple_ul'),
                    'items' => array(
                        array('label' => 'На сегодня', 'url' => array('index'), 'linkOptions' => array('class' => 'menu-link-simple_a'), 'visible' => Yii::app()->controller->action->id !== 'index'),
                        array('label' => 'На завтра', 'url' => array('tomorrow'), 'linkOptions' => array('class' => 'menu-link-simple_a'), 'visible' => Yii::app()->controller->action->id !== 'tomorrow'),
                        array('label' => 'На месяц', 'url' => array('month'), 'linkOptions' => array('class' => 'menu-link-simple_a'), 'visible' => Yii::app()->controller->action->id !== 'month'),
                        array('label' => 'На год', 'url' => array('year'), 'linkOptions' => array('class' => 'menu-link-simple_a'), 'visible' => Yii::app()->controller->action->id !== 'year'),
                        array('label' => 'Гороскоп совместимости', 'template' => '<span class="color-gray">+ &nbsp;</span>{menu}', 'url' => array('/services/horoscope/compatibility/index'), 'linkOptions' => array('class' => 'menu-link-simple_a')),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php
/*$model = new HoroscopeCompatibility();
$this->renderPartial('/compatibility/_compatibility_form', array('model' => $model, 'showTitle' => true));*/