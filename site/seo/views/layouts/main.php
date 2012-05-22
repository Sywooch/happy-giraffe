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
        ->registerScriptFile('/js/seo-editor.js')

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
    <style type="text/css">
        .default-nav li span.tale {
            display: none;
        }
        .default-nav li.active span.tale {
            display: block;
        }

        .loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff url(/images/loading.gif) no-repeat center !important;z-index: 100;
            opacity: 0.5;
        }
    </style>
</head>
<body>

    <div id="seo" class="wrapper">

        <div class="clearfix">
            <div class="default-nav">
                <?php if (Yii::app()->user->checkAccess('editor')):?>
                <ul>
                    <li<?php if (Yii::app()->controller->action->id == 'index' ) echo ' class="active"' ?>>
                        <a href="<?=$this->createUrl('editor/index') ?>">Ключевые слова или фразы</a><span class="tale"><img src="/images/default_nav_active.gif"></span></li>
                    <li<?php if (Yii::app()->controller->action->id == 'tasks' ) echo ' class="active"' ?>>
                        <a href="<?=$this->createUrl('editor/tasks') ?>">Раздача заданий</a>
                        <span class="tale"><img src="/images/default_nav_active.gif"></span>
                        <div class="count"><a href="<?=$this->createUrl('editor/tasks') ?>"><?=TempKeywords::model()->count('owner_id='.Yii::app()->user->id) ?></a></div>
                    </li>
                    <li<?php if (Yii::app()->controller->action->id == 'history' ) echo ' class="active"' ?>>
                        <a href="<?=$this->createUrl('editor/reports') ?>">Отчеты</a></li>
                </ul>
                <?php endif ?>

                <?php if (Yii::app()->user->checkAccess('admin')):?>
                <ul>
                    <li><a href="/user/">Пользователи</a></li>
                    <li><a href="/existArticles/">Готовое</a></li>
                    <li><a href="/task/index/">Задания рерайт</a></li>
                </ul>
                <?php endif ?>

            </div>
            <div class="title">
                <span>SEO-<span>жираф</span></span> &nbsp; <?= $this->pageTitle ?>
            </div>
        </div>

        <?=$content ?>

    </div>

    <div class="loading" style="display: none;">

    </div>

</body>
</html>