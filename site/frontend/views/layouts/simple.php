<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$this->pageTitle?></title>

    <link rel="stylesheet" type="text/css" href="/redactor/redactor.css" />
    <link rel="stylesheet" type="text/css" href="/stylesheets/common.css" />
    <link rel="stylesheet" type="text/css" href="/stylesheets/global.css" />
    <link rel="stylesheet" type="text/css" href="/stylesheets/user.css" />
    <link rel="stylesheet" type="text/css" href="/stylesheets/baby.css" />

    <?php
        Yii::app()->clientScript
            ->registerCoreScript('jquery')
        ;
    ?>

    <!--[if IE 7]>
        <link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
    <![endif]-->

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">
</head>
<body class="body-gray">

    <div class="layout-container">
        <div class="layout-container_hold">

            <div class="layout-wrapper">
                <div class="clearfix">
                    <div class="logo-box">
                        <a title="Веселый жираф - Happy-giraffe.ru" class="logo" href="/">Веселый жираф</a>
                        <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                    </div>
                </div>

                <?=$content?>

                <div class="footer-push"></div>

            </div>
        </div>
    </div>

</body>
</html>
