<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if IE 8]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie8"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Персональный календарь беременности на Веселом Жирафе</title>


    <link rel="stylesheet" type="text/css" href="/stylesheets/common.css" />
    <link rel="stylesheet" type="text/css" href="/stylesheets/landing-pages/calendar-pregnancy.css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="/javascripts/jquery.placeholder.min.js"></script>


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

    <form action="">
        <div class="logo-box">
            <a href="/" class="logo" title="Домашняя страница">Ключевые слова сайта</a>
            <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
        </div>
        <h2>Персональный календарь беременности</h2>
        <div class="free">БЕСПЛАТНО!</div>
        <p class="bigtext">Присоединяйтесь к сообществу будущих мам! <br /> Общайтесь, получайте советы по ведению беременности и пользуйтесь различными сервисами</p>
        <p class="smalltext">Присоединяйтесь к сообществу будущих мам! <br /> Общайтесь, получайте советы по ведению беременности.</p>
        <div class="row">
            <input type="text" class="text" placeholder="Введите ваш e-mail адрес" value=""/>
        </div>
        <input type="submit" value="Продолжить"  class="btn-green"/>
        <div class="social-small-row clearfix">
            <em>или войти с помощью</em>
            <ul class="social-list-small">
                <li><a href="#" class="odnoklasniki"></a></li>
                <li><a href="#" class="mailru"></a></li>
                <li><a href="#" class="vk"></a></li>
                <li><a href="#" class="fb"></a></li>
            </ul>
        </div>
    </form>

</div>

</body>
</html>
