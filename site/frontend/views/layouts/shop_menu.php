<?php

return array(
	array('label' => 'Сайт', 'url' => array('/site/index')),

	array('label' => 'Категории', 'url' => array('/admin/category/admin'), 'visible' => !Yii::app()->user->isGuest),

	array('label' => 'Атрибуты', 'url' => '#', 'visible' => !Yii::app()->user->isGuest, 'items'=>array(
		array('label' => 'Атрибуты', 'url' => array('/attribute')),
		array('label' => 'Наборы атрибутов', 'url' => array('/attribute/attributeSet/admin')),
	)),

	array('label' => 'Товары', 'url' => '#', 'visible' => !Yii::app()->user->isGuest, 'items'=>array(
		array('label' => 'Возврасты', 'url' => array('/admin/ageRange/admin')),
		array('label' => 'Бренды', 'url' => array('/admin/productBrand/admin')),
//		array('label' => 'Типы товаров', 'url' => array('/admin/productType/admin')),
		array('label' => 'Товары', 'url' => array('/admin/product/admin')),
//		array('label' => 'Наборы товаров', 'url' => array('/admin/productSet/admin')),
//		array('label' => 'Прайс-лист', 'url' => array('/admin/productPricelist/admin')),
	)),

	array('label' => 'Ваучеры', 'url' => array('/admin/vaucher/admin'), 'visible' => !Yii::app()->user->isGuest),
	
	array('label' => 'Заказы', 'url' => array('/admin/order/admin'), 'visible' => !Yii::app()->user->isGuest),
	
	array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
);