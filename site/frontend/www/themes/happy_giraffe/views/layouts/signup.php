<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>
    <?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php
        $cs = Yii::app()->clientScript;

        $cs
            ->registerCssFile('/stylesheets/common.css')
            ->registerCssFile('/stylesheets/registration.css')
            ->registerCoreScript('jquery')
            ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')
            ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js')
            ->registerScriptFile('/javascripts/common.js')
            ->registerCssFile('/stylesheets/ie.css', 'screen')
        ;
    ?>
</head>
<body>

<div>

    <div id="registration">

        <div class="header clearfix">

            <div class="a-right login-link">
                <span class="login-q">&mdash; Если Вы уже зарегистрированы?</span>
                <a href="#login" class="btn btn-orange fancy"><span><span>Вход на сайт</span></span></a>
            </div>

            <div class="logo-box"><a title="hg.ru" class="logo">Ключевые слова сайта</a></div>

        </div>

        <div class="content">

            <?php echo $content; ?>

        </div>


    </div>

</body>
</html>