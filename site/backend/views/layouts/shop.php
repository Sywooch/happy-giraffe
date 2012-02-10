<?php $this->beginContent('//layouts/main'); ?>
<!-- .header -->
<div class="navigation">

    <?php
    $this->widget('zii.widgets.CMenu', array(
        'linkLabelWrapper' => 'span',
        'items' => array(
            array(
                'label' => 'Главная',
                'url' => array('site/index'),
            ),
            array('label' => 'Категории',
                'url' => array('category/index'),
                'active' => (Yii::app()->controller->id == 'category' || Yii::app()->controller->id == 'attributeSet'),
                'itemOptions' => array('class' => 'submenu'),
                'items' => array(
                    array(
                        'label' => 'Категории',
                        'url' => array('category/index'),
                    ),
                    array(
                        'label' => 'Пакеты свойств',
                        'url' => array('#'),
                    ),
                )
            ),
            array('label' => 'Товары',
                'url' => array('product/index'),
                'active' => (Yii::app()->controller->id == 'product' || Yii::app()->controller->id == 'brand'),
                'itemOptions' => array('class' => 'submenu'),
                'items' => array(
                    array(
                        'label' => 'Товары',
                        'url' => array('product/index'),
                    ),
                    array(
                        'label' => 'Бренды',
                        'url' => array('brand/index'),
                    ),
                )
            ),
            array(
                'label' => 'Скидки',
                'url' => array('#'),
            ),
            array(
                'label' => 'Оплата',
                'url' => array('#'),
            ),
            array(
                'label' => 'Доставка',
                'url' => array('#'),
            ),
            array(
                'label' => 'Заказы',
                'url' => array('#'),
            ),
            array(
                'label' => 'Пользователи',
                'url' => array('users/index'),
            ),
        ),
    ));?>
    <div class="clear"></div>
    <!-- .clear -->
</div>
<!-- .navigation -->
<div class="content">

    <?php echo $content; ?>

</div>
<!-- .content -->
<?php $this->endContent(); ?>