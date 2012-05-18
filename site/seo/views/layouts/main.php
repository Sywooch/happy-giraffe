<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <?php
    Yii::app()->clientScript
        ->registerCssFile('/css/seo.css')
        ->registerCssFile('/css/form.css')

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

//        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/comet.js')
//        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/dklab_realplexor.js')
//        ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');')
    ;
    ?>
</head>
<body>

    <div id="seo" class="wrapper">

        <div class="title">
            <span>SEO-<span>жираф</span></span> &nbsp; ГОТОВОЕ
        </div>
        <div>
            <?php if (Yii::app()->user->checkAccess('admin')):?>
            <a href="/user/">Пользователи</a> <a href="/existArticles/">Готовое</a> <a href="/task/index/">Задания рерайт</a>
            <?php endif ?>
        </div>

        <?=$content ?>

    </div>

</body>
</html>