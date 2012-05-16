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

        ->registerCssFile('/css/jquery.ui/base.css')
        ->registerCssFile('/css/jquery.ui/theme.css')

        ->registerScriptFile('/js/jquery.tooltip.js')

        ->registerScriptFile('/js/seo.js')

        ->registerScriptFile('/js/jquery.tmpl.min.js')

        ->registerScriptFile('/js/jquery.pnotify.min.js')
        ->registerCssFile('/css/jquery.pnotify.css')
        ->registerCssFile('/css/reset.css')

        ->registerScriptFile('/js/jquery.iframe-post-form.js')

        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/comet.js')
        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/dklab_realplexor.js')
        ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');')
    ;
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
    <div>
        <?php if (Yii::app()->user->checkAccess('editor')):?>
        <a href="/task/index/">Выбор кейвордов</a> <a href="/task/tasks/">Задания копирайт</a> <a href="/task/rewriteTasks/">Задания рерайт</a>
        <?php endif ?>
    </div>
    <br><br><br>
    <?php echo $content; ?>

    <br><br><br>
    <div class="footer">
        <span>&copy; Все права защищены.</span>
    </div>
</div>

</body>
</html>