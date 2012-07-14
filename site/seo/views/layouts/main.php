<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <?php
    echo CHtml::linkTag('shortcut icon', null, '/favicon.bmp');

    $release_id = 23;
    Yii::app()->clientScript
        ->registerCssFile('/css/seo.css?r='.$release_id)
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
                    'label' => 'Сайты',
                    'url' => array('/admin/site/'),
                ),
                array(
                    'label' => 'Запросы',
                    'url' => array('/admin/query/'),
                ),
                array(
                    'label' => 'Пользователи',
                    'url' => array('/admin/user/'),
                ),
                array(
                    'label' => 'Страницы',
                    'url' => array('/admin/page/'),
                ),
                array(
                    'label' => 'Запросы ПС',
                    'url' => array('/admin/querySearchEngine/'),
                ),
                array(
                    'label' => 'Поисковые фразы страниц',
                    'url' => array('/admin/pagesSearchPhrase/'),
                ),
                array(
                    'label' => 'Поисковые фразы - визиты',
                    'url' => array('/admin/searchPhraseVisit/'),
                ),
                array(
                    'label' => 'Поисковые фразы - позиции',
                    'url' => array('/admin/searchPhrasePosition/'),
                ),
                array(
                    'label' => 'Парсинг и прокси',
                    'url' => array('/parsing/index/'),
                ),
                array(
                    'label' => 'Парсинг Запросов и позиций',
                    'url' => array('/promotion/queries/index/'),
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