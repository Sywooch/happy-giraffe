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
            background: #fff url(/images/loading.gif) no-repeat center !important;
            z-index: 100;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<div id="seo" class="wrapper">
    <a href="/logout/">выйти</a>

    <div class="clearfix">
        <div class="default-nav">

            <?php
            if (Yii::app()->user->checkAccess('editor'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'Ключевые слова или фразы',
                            'url' => array('/editor/index/'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('editor/tasks') . '">' . TempKeywords::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/editor/reports/'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('superuser'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'Готовое',
                            'url' => array('/existArticles/index/'),
                        ),
                        array(
                            'label' => 'Конкуренты',
                            'url' => array('/default/competitors/'),
                        ),
                        array(
                            'label' => 'Ключевые слова или фразы',
                            'url' => array('/editor/index/'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('editor/tasks') . '">' . TempKeywords::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/editor/reports/'),
                        ),
                        array(
                            'label' => 'Запросы',
                            'url' => array('/queries/admin/'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('admin'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'Ключевые слова или фразы',
                            'url' => array('/editor/index/'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('editor/tasks') . '">' . TempKeywords::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Конкуренты',
                            'url' => array('/default/competitors'),
                        ),
                        array(
                            'label' => 'Пользователи',
                            'url' => array('/user/'),
                            'active' => Yii::app()->controller->id == 'user'
                        ),
                        array(
                            'label' => 'Готовое',
                            'url' => array('/existArticles/index/'),
                        ),
                        array(
                            'label' => 'Парсинг',
                            'url' => array('/queries/index/'),
                        ),
                        array(
                            'label' => 'Запросы',
                            'url' => array('/queries/admin/'),
                        ),
                    )));


            if (Yii::app()->user->checkAccess('moderator'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/task/moderator'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/task/moderatorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('author'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/task/author'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/task/authorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('corrector'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/task/corrector'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/task/correctorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('content-manager'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/task/contentManager'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/task/contentManagerReports'),
                        ),
                    )));

            ?>
        </div>
        <div class="title">
            <i class="img"></i>
            <span>SEO-<span>жираф</span></span> &nbsp; <?= $this->pageTitle ?>
        </div>
    </div>

    <?=$content ?>

</div>

<div class="loading" style="display: none;">

</div>

</body>
</html>