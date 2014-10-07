<?php
// Эти скрипты модуль рагистрирует пакетом, подменим на новые версии для нового шаблона
Yii::app()->clientScript->scriptMap['jquery.js'] = '/new/javascript/jquery-1.10.2.min.js';
Yii::app()->clientScript->scriptMap['jquery.powertip.js'] = '/new/javascript/jquery.powertip.js';
Yii::app()->clientScript->scriptMap['baron.js'] = '/new/javascript/baron.js';
Yii::app()->clientScript->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-3.0.0.js';
Yii::app()->clientScript->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-debug.3.0.0.js';
if (! Yii::app()->user->isGuest)
    Yii::app()->clientScript
        ->registerScript('serverTime', 'var serverTime = ' . time() . '; serverTimeDelta = new Date().getTime() - (serverTime * 1000)', CClientScript::POS_HEAD)
        ->registerPackage('comet')
        ->registerPackage('common')
        ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');');

?><!DOCTYPE html>
<html class="no-js">
<head><meta charset="utf-8">
    <title>Happy Giraffe</title>
    <!-- including .css--><link rel="stylesheet" type="text/css" href="/new/redactor/redactor.css" />
    <link rel="stylesheet" type="text/css" href="/new/css/all1.css" />
    <!-- <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,cyrillic-ext,cyrillic"> -->
    <script src="/new/javascript/jquery.tooltipster.js"></script>
    <script src="/new/javascript/modernizr-2.7.1.min.js"></script>
    <!-- wisywig-->
    <script src="/new/redactor/redactor.js"></script>
</head>
<body class="body">
<?=$content?>
</body>
</html>