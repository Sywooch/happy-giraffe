<?php
/* @var $this HController
 * @var $models Horoscope[]
 */
?>
    <div class="horoscope-list">

        <h1><?=$this->title ?></h1>

        <p>Нравится ли вам возможность ежедневно советоваться со звёздами? Наверняка вы не раз читали гороскоп для своего знака Зодиака. Что-то в нём вам казалось смешным, а что-то – полезным. Действительно, в то время как одни считают гороскоп сегодня руководством к действию, другие относятся к нему как к пустой забаве. Наверное, это связано с качеством гороскопа. Оцените работу нашего эксклюзивного астролога – прочитайте, что он написал для вас сегодня, нажав на нужный знак Зодиака.</p>

        <ul><?php foreach ($models as $model)
            $this->renderPartial('_preview',compact('model'));
        ?></ul>

    </div>

    <div class="wysiwyg-content">

        <?=ServiceText::getText('horoscope', 'today') ?>

    </div>

<?php
$model = new HoroscopeCompatibility();
$this->renderPartial('/compatibility/_compatibility_form', array('model'=>$model, 'showTitle'=>true)); ?>