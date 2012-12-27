<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Сигналы</title>

    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js'); ?>

    <?php Yii::app()->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile('/javascripts/common.js')
    ->registerScriptFile('/javascripts/comet.js')
    ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
    ->registerCssFile('/stylesheets/common.css')
    ->registerScriptFile('/javascripts/dklab_realplexor.js')
    ->registerScriptFile('/javascripts/tooltipsy.min.js')
    ->registerScript('Realplexor-reg', '
    comet.connect("http://' . Yii::app()->comet->host . '", "' . Yii::app()->comet->namespace . '",
                  "' . UserCache::GetCurrentUserCache() . '");
');

    ?>
</head>
<body class="body-club">
<div id="layout" class="wrapper">
    <div id="content" class="clearfix">
        <div id="signals">
            <?php echo $content ?>
        </div>
    </div>
</div>
</body>
</html>
