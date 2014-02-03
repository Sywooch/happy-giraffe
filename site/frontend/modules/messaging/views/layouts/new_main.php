<?php
	// Эти скрипты модуль рагистрирует пакетом, подменим на новые версии для нового шаблона
	Yii::app()->clientScript->scriptMap['jquery.js'] = '/new/javascript/jquery-1.10.2.min.js';
	Yii::app()->clientScript->scriptMap['jquery.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/jquery-1.10.2.min.js';
    Yii::app()->clientScript->scriptMap['jquery.min.js'] = '/new/javascript/jquery-1.10.2.min.js';
    Yii::app()->clientScript->scriptMap['jquery.min.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/jquery-1.10.2.min.js';
	Yii::app()->clientScript->scriptMap['jquery.powertip.js'] = '/new/javascript/jquery.powertip.js';
	Yii::app()->clientScript->scriptMap['jquery.powertip.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/jquery.powertip.js';
	Yii::app()->clientScript->scriptMap['baron.js'] = '/new/javascript/baron.js';
	Yii::app()->clientScript->scriptMap['baron.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/baron.js';
	Yii::app()->clientScript->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-3.0.0.js';
	Yii::app()->clientScript->scriptMap['knockout-2.2.1.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/knockout-3.0.0.js';
	Yii::app()->clientScript->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-debug.3.0.0.js';
	Yii::app()->clientScript->scriptMap['knockout-2.2.1.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/knockout-debug.3.0.0.js';
	if (! Yii::app()->user->isGuest)
		Yii::app()->clientScript
			->registerScript('serverTime', 'var serverTime = ' . time() . ' * 1000; serverTimeDelta = new Date().getTime() - serverTime', CClientScript::POS_HEAD)
			->registerPackage('comet')
			->registerPackage('common')
			->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');');

?><!DOCTYPE html>
<html class="no-js">
  <head><meta charset="utf-8">
    <title>Happy Giraffe</title>
    <!-- including .css--><link rel="stylesheet" type="text/css" href="/new/redactor/redactor.css" />
    <link rel="stylesheet" type="text/css" href="/new/css/all1.css" />
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,cyrillic-ext,cyrillic">
	<script src="/new/javascript/jquery.tooltipster.js"></script>
    <script src="/new/javascript/modernizr-2.7.1.min.js"></script>
    <!-- wisywig-->
    <script src="/new/redactor/redactor.js"></script>
  </head>
  <body class="body body__im">
    <div class="layout-container">
      <!-- header-->
      <div class="header">
        <div class="header_hold clearfix">
          <!-- logo-->
          <div class="logo"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
          <!-- /logo-->
          <!-- header-menu-->
          <div class="header-menu">
            <ul class="header-menu_ul clearfix">
              <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span></a></li>
              <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">Диалоги</span><span class="header-menu_count">25456</span></a></li>
              <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__friend"></span><span class="header-menu_tx">Друзья</span><span class="header-menu_count">2</span></a></li>
              <li class="header-menu_li active"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__notice"></span><span class="header-menu_tx">Сигналы</span><span class="header-menu_count">2</span></a></li>
              <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__award"></span><span class="header-menu_tx">Успехи</span></a></li>
              <li class="header-menu_li header-menu_li__dropin"><a href="/my" class="header-menu_a"><span href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span><span class="header-menu_tx">Я<span class="header-menu_i-arrow"></span></span></a></li>
            </ul>
          </div>
          <!-- /header-menu-->
        </div>
      </div>
      <!-- /header-->
      <div class="layout-wrapper">
        <div class="layout-wrapper_hold clearfix">
			<?=$content?>
        </div>
      </div>
    </div>
  </body>
</html>