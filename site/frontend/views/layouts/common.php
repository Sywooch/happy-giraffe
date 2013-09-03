<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=$this->pageTitle?></title>
        <?php
            Yii::app()->clientScript
                ->registerCssFile('/redactor/redactor.css')
                ->registerCssFile('/stylesheets/common.css')
                ->registerCssFile('/stylesheets/global.css')
                ->registerCssFile('/stylesheets/user.css')
                ->registerCssFile('/stylesheets/baby.css')
                ->registerCssFile('http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext')

                ->registerCoreScript('jquery')
            ;
        ?>

        <!--[if IE 7]>
            <link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
        <![endif]-->
    </head>
    <body class="body-gray">
        <?=$content?>
    </body>
</html>