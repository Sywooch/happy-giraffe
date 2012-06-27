<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <?php
    CHtml::linkTag('shortcut icon', null, '/favicon.bmp');

    Yii::app()->clientScript
        ->registerCssFile('/css/seo.css')
        ->registerCssFile('/css/form.css')
        ->registerCssFile('/css/my.css')

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

        ->registerScriptFile('/js/jquery.iframe-post-form.js');
    ?>
    <script type="text/javascript">
        $(function () {
            $('#admin-menu').mouseover(function () {
                $(this).css('opacity', 1);
            });
            $('#admin-menu').mouseout(function () {
                $(this).css('opacity', 0.6);
            });
        });
    </script>
</head>
<body>

<div id="seo" class="wrapper">

    <div class="clearfix">
        <div class="default-nav">

            <?php
            if (Yii::app()->user->checkAccess('editor'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'Конкуренты',
                            'url' => array('/competitors/default/index'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/writing/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/editor/reports/'),
                        ),
                        array(
                            'label' => 'Поисковый трафик',
                            'url' => array('/queries/admin'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('superuser'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'Готовое',
                            'url' => array('/writing/existArticles/index/'),
                        ),
                        array(
                            'label' => 'Конкуренты',
                            'url' => array('/competitors/default/index'),
                        ),
                        array(
                            'label' => 'Ключевые слова или фразы',
                            'url' => array('/writing/editor/index/'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/writing/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/editor/reports/'),
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
                            'label' => 'Поисковый трафик',
                            'url' => array('/queries/admin'),
                        ),
                        array(
                            'label' => 'Ключевые слова или фразы',
                            'url' => array('/writing/editor/index/'),
                        ),
                        array(
                            'label' => 'Раздача заданий',
                            'url' => array('/writing/editor/tasks/'),
                            'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                        ),
                        array(
                            'label' => 'Конкуренты',
                            'url' => array('/competitors/default/index'),
                        ),
                        array(
                            'label' => 'Готовое',
                            'url' => array('/writing/existArticles/index/'),
                        ),
                    )));


            if (Yii::app()->user->checkAccess('moderator'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/writing/task/moderator'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/task/moderatorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('author'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/writing/task/author'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/task/authorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('corrector'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/writing/task/corrector'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/task/correctorReports'),
                        ),
                    )));

            if (Yii::app()->user->checkAccess('content-manager'))
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                    'items' => array(
                        array(
                            'label' => 'В работу',
                            'url' => array('/writing/task/contentManager'),
                        ),
                        array(
                            'label' => 'Отчеты',
                            'url' => array('/writing/task/contentManagerReports'),
                        ),
                    )));

            ?>
        </div>

        <div class="title">
            <div class="user-info clearfix">
                <div class="ava small"><img src="<?=Yii::app()->user->getModel()->getAva() ?>" alt=""></div>
                <div class="details">
                    <a href="javascript:;" class="username" onclick="$('.user-info .nav').toggle();"><?=Yii::app()->user->getModel()->name ?><i class="arr"></i></a>
                </div>
                <div class="nav" style="display: none;">
                    <div class="btn-logout"><a href="/logout/" class="logout"><i class="icon"></i>Выход</a></div>
                </div>
            </div>

            <i class="img"></i>
            <span>SEO-<span>жираф</span></span> &nbsp; <?= $this->pageTitle ?>
        </div>

        <?php if (!empty($this->fast_nav)): ?>
        <div class="fast-nav">
            <?php $this->widget('zii.widgets.CMenu', array(
            'items' => $this->fast_nav
        ));?>
        </div>
        <?php endif ?>

    </div>

    <?=$content ?>

</div>

<div class="loading" style="display: none;">

</div>

<?php if (Yii::app()->user->checkAccess('admin')): ?>
<div id="admin-menu">
    <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Пользователи',
                    'url' => array('/user/'),
                    'active' => Yii::app()->controller->id == 'user'
                ),
                array(
                    'label' => 'Запросы',
                    'url' => array('/queries/admin/'),
                ),
                array(
                    'label' => 'Готовые статьи',
                    'url' => array('/writing/page/admin/'),
                ),
                array(
                    'label' => 'Парсинг и прокси',
                    'url' => array('/parsing/index/'),
                ),
                array(
                    'label' => 'Парсинг Запросов и позиций',
                    'url' => array('/queries/index/'),
                ),
                array(
                    'label' => 'Парсинг Вордстата',
                    'url' => array('/wordstat/index'),
                ),
                array(
                    'label' => 'Парсинг LI',
                    'url' => array('/competitors/parse/index'),
                ),
            )));
    ?>
</div>
<?php endif; ?>

</body>
</html>