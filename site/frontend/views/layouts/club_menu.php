<?php

return array(
	array('label' => 'Home', 'url' => array('/site/index')),
	array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
	array('label' => 'Contact', 'url' => array('/site/contact')),
	array('label' => 'Форум', 'url' => array('/theme/index')),

	array('label' => 'Регистрация', 'url' => array('/site/register'), 'visible' => Yii::app()->user->isGuest),
	array('label' => 'Профиль', 'url' => array('/site/profile'), 'visible' => !Yii::app()->user->isGuest),
	array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array('onclick' => "showPopup('login_popup'); return false;")),
	array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
);