<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <?php
    Yii::app()->clientScript
        ->registerCoreScript('jquery')
        ->registerCoreScript('jquery.ui')

        ->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js')
        ->registerCssFile('/css/jquery.fancybox-1.3.4.css')

        ->registerScriptFile('/js/jquery.tooltip.js')

        ->registerScriptFile('/js/seo.js')

        ->registerScriptFile('/js/jquery.tmpl.min.js')

        ->registerScriptFile('/js/jquery.pnotify.min.js')
        ->registerCssFile('/css/jquery.pnotify.css')

        ->registerScriptFile('/js/jquery.iframe-post-form.js');
    ?>
</head>
<body>
<div id="wrapper">
    <div class="header">
        <a href="/" class="logo" title="Обновить страницу">Администратор</a>
        <!-- .logo -->
        <ul class="logged">
            <li><?php echo Yii::app()->user->name ?></li>
            <li><a href="<?php echo $this->createUrl('site/logout') ?>">Выйти</a></li>
        </ul>
    </div>
    <?php echo $content; ?>

    <div class="clear"></div>

    <div class="footer">
        <span>&copy; Все права защищены.</span>
    </div>
</div>

</body>
</html>