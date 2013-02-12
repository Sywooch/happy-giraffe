<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head title="Весёлый жираф - мобильная версия">

        <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport">
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <meta content="telephone=no" name="format-detection">
        <meta content="176" name="/Optimized">
        <title>Весёлый жираф - мобильная версия</title>
        <!--
        CSS
        Конечному пользователю нужно отправлять скомпилированный файл css
        <link rel="stylesheet" href="/css/all.css" type="text/css" />
         -->
        <link rel="stylesheet" href="/css/all-dev.css" type="text/css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script src="/js/common.js"></script>

    </head>
    <body>
        <div class="layout-page">
            <div class="logo">
                <a href="<?=Yii::app()->homeUrl?>" class="logo_a">Веселый жираф</a>
            </div>

            <div class="nav">
                <span class="nav_t" >Разделы</span>
                <div class="nav_hold">
                    <ul class="nav_ul">
                        <li class="nav_li">
                            <a href="" class="nav_i">
                                <i class="nav_ico nav_ico__club"></i>
                                Клубы
                                <span class="nav_arrow-down"></span>
                            </a>
                            <div class="nav-drop">
                                <ul class="nav-drop_ul">
                                    <?php foreach ($this->communities as $community): ?>
                                        <li class="nav-drop_li">
                                            <?=CHtml::link($community->title, $community->url, array('class' => 'nav-drop_i'))?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav_li">
                            <a href="" class="nav_i">
                                <i class="nav_ico nav_ico__blog"></i>
                                Блоги
                            </a>
                        </li>
                        <li class="nav_li">
                            <a href="" class="nav_i">
                                <i class="nav_ico nav_ico__horoscope"></i>
                                Гороскопы
                            </a>
                        </li>
                        <li class="nav_li">
                            <a href="" class="nav_i">
                                <i class="nav_ico nav_ico__cook"></i>
                                Рецепты
                                <span class="nav_arrow-down"></span>
                            </a>
                            <div class="nav-drop">
                                <ul class="nav-drop_ul">
                                    <li class="nav-drop_li">
                                        <?=CHtml::link('Обычные', Yii::app()->createUrl('/cook/recipe/index', array('section' => 0)), array('class' => 'nav-drop_i'))?>
                                    </li>
                                    <li class="nav-drop_li">
                                        <?=CHtml::link('Для мультиварки', Yii::app()->createUrl('/cook/recipe/index', array('section' => 1)), array('class' => 'nav-drop_i'))?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <div class="nav-search">
                        <div class="nav-search_hold">
                            <input type="text" name="" id="" class="nav-search_itx" placeholder="Поиск"/>
                            <input type="submit" class="nav-search_btn btn-green" value="Поиск"/>
                        </div>
                    </div>
                </div>
            </div>

            <?=$content?>

            <div class="footer">
                <div class="margin-b5">
                    <a href="" class="full-version">Полная версия</a>
                </div>
                <div class="clearfix">
                    Веселый Жираф © 2012-2013 <br>Все права защищены
                </div>
            </div>
        </div>
    </body>
</html>