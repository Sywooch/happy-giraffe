<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>SEO-жираф</title>

    <?php
    echo CHtml::linkTag('shortcut icon', null, '/favicon.bmp');

    $release_id = 35;
    Yii::app()->clientScript
        ->registerCssFile('/css/seo.css?'.$release_id)
        ->registerCssFile('/css/form.css?'.$release_id)
        ->registerCssFile('/css/my.css?'.$release_id)

        ->registerCoreScript('jquery')
        ->registerCoreScript('jquery.ui')

        ->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js')
        ->registerCssFile('/css/jquery.fancybox-1.3.4.css')

        ->registerCssFile('/css/jquery.ui/base.css')
        ->registerCssFile('/css/jquery.ui/theme.css')

        ->registerScriptFile('/js/jquery.tooltip.js')

        ->registerScriptFile('/js/common.js?'.$release_id)
        ->registerScriptFile('/js/seo.js?'.$release_id)
        ->registerScriptFile('/js/seo-editor.js?'.$release_id)

        ->registerScriptFile('/js/jquery.tmpl.min.js')

        ->registerScriptFile('/js/jquery.pnotify.min.js?'.$release_id)
        ->registerCssFile('/css/jquery.pnotify.css?'.$release_id)
        ->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css?'.$release_id)
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

    <?php if (false && !SeoUserAttributes::getAttribute('close_advert_' . SeoUserAttributes::ADVERT_ID)): ?>
        <div class="advert">
            <a href="javascript:;" class="popup-close" onclick="Advert.close()"></a>
            <span>В субботу 27 октября сео-сайт работать не будет, плановые технические работы. Спасибо :)</span>
        </div>
    <?php endif ?>

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
                    'label' => 'Поисковые фразы - позиции',
                    'url' => array('/admin/searchPhrasePosition/'),
                ),
                array(
                    'label' => 'Парсинг Запросов и позиций',
                    'url' => array('/promotion/queries/index/'),
                ),
                array(
                    'label' => 'Урлы индексации',
                    'url' => array('/admin/indexingUrl/admin/'),
                ),
                array(
                    'label' => 'Комментаторы',
                    'url' => array('/admin/Commentator/admin/'),
                ),
                array(
                    'label' => 'Внешние ссылки - сайты',
                    'url' => array('/externalLinks/admin/site/admin/'),
                ),
                array(
                    'label' => 'Внешние ссылки - ссылки',
                    'url' => array('/externalLinks/admin/link/admin/'),
                ),
                array(
                    'label' => 'Внешние ссылки - задания',
                    'url' => array('/externalLinks/admin/task/admin/'),
                ),

            )));
    ?>
<?php endif; ?>
</div>
<div>
    <?php echo '<div>';
    echo 'Отработало за ' . sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) . ' с. ';
    echo 'Скушано памяти: ' . round(memory_get_peak_usage() / (1024 * 1024), 2) . ' MB';
    echo '<br>';
    $sql_stats = YII::app()->db->getStats();
    echo $sql_stats[0] . ' запросов к БД. ';
    echo 'время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.';
    echo '</div>';?>
</div>
<br><br>
</body>
</html>