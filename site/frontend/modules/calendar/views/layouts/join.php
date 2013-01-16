<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if IE 8]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie8"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Персональный календарь беременности на Веселом Жирафе</title>

    <link rel="stylesheet" type="text/css" href="/stylesheets/landing-pages/calendar-pregnancy.css" />

    <?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/common.css')
        ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')

        ->registerCoreScript('jquery')
        ->registerScriptFile('/javascripts/tooltipsy.min.js')
        ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.js')
        ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
        ->registerScriptFile('/javascripts/chosen.jquery.min.js')
        ->registerScript('base_url', 'var base_url = \'' . Yii::app()->baseUrl . '\';', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/common.js')
        ->registerScriptFile('/javascripts/addtocopy.js')
        ->registerScriptFile('/javascripts/base64.js')
    ;
    ?>

    <!--[if IE 7]>
    <link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
    <![endif]-->

    <script type="text/javascript">
        function photoPregnancy(){
            var winWidth = $(document).width();
            if (winWidth < 1920) {
                var photoSize = winWidth * 0.8 * (750 / 1920);
                $(".photo-pregnancy").width(photoSize);

            }
        }

        function calendarPregnancyForm () {
            formTop =  ($(window).height() - $(".calendar-pregnancy-form").height() ) / 2;
            if (formTop > 0) {
                $(".calendar-pregnancy-form").css("top", formTop);
            } else {
                $("body").addClass(" smallscreen");
                formTop =  ($(window).height() - $(".calendar-pregnancy-form").height() ) / 2;
                if (formTop > 0) {
                    $(".calendar-pregnancy-form").css("top", formTop);
                }
            }
        }

        $(document).ready(function () {
            photoPregnancy();

            calendarPregnancyForm ();

        });
        $(window).resize(function () {
            photoPregnancy();

            calendarPregnancyForm ();
        });
    </script>

</head>
<body class="body-club">
<div class="calendar-pregnancy-holder">
    <img src="/images/landing-pages/calendar-pregnancy/photo4.jpg" alt="" width="750" class="photo-pregnancy photo-pregnancy4"/>
    <img src="/images/landing-pages/calendar-pregnancy/photo3.jpg" alt="" width="750" class="photo-pregnancy photo-pregnancy3"/>
    <img src="/images/landing-pages/calendar-pregnancy/photo2.jpg" alt="" width="750" class="photo-pregnancy photo-pregnancy2"/>
    <img src="/images/landing-pages/calendar-pregnancy/photo1.jpg" alt="" width="750" class="photo-pregnancy photo-pregnancy1"/>
</div>

<div class="calendar-pregnancy-form">

    <?=$content ?>

</div>

</body>
</html>
