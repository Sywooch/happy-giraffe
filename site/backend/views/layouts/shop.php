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
                ),
                'visible' => Yii::app()->user->checkAccess('shop')
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
                ),
                'visible' => Yii::app()->user->checkAccess('shop')
            ),
            array(
                'label' => 'Скидки',
                'url' => array('#'),
                'visible' => Yii::app()->user->checkAccess('shop')
            ),
            array(
                'label' => 'Оплата',
                'url' => array('#'),
                'visible' => Yii::app()->user->checkAccess('shop')
            ),
            array(
                'label' => 'Доставка',
                'url' => array('#'),
                'visible' => Yii::app()->user->checkAccess('shop')
            ),
            array(
                'label' => 'Заказы',
                'url' => array('#'),
                'visible' => Yii::app()->user->checkAccess('shop')
            ),
            array(
                'label' => 'Пользователи',
                'url' => array('users/index'),
                'itemOptions' => array('class' => 'submenu'),
                'visible' => (Yii::app()->user->checkAccess('user access') ||
                    Yii::app()->user->checkAccess('удаление пользователей')),
                'items' => array(
                    array(
                        'label' => 'Назначения',
                        'url' => array('UserRoles/admin'),
                        'visible' => Yii::app()->user->checkAccess('user access'),
                    ),
                    array(
                        'label' => 'Роли',
                        'url' => array('roles/admin'),
                        'visible' => Yii::app()->user->checkAccess('user access'),
                    ),
                    array(
                        'label' => 'Группы действий',
                        'url' => array('operationGroups/admin'),
                        'visible' => Yii::app()->user->checkAccess('user access'),
                    ),
                    array(
                        'label' => 'Действия',
                        'url' => array('operations/admin'),
                        'visible' => Yii::app()->user->checkAccess('user access'),
                    ),
                    array(
                        'label' => 'Проверка Профилей',
                        'url' => array('profileFill/'),
                        'visible' => Yii::app()->user->checkAccess('user access'),
                    ),
                )
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