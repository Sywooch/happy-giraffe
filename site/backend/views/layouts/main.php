<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <link href="/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/css/general.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

    <script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/js/jquery.tooltip.js"></script>
    <script type="text/javascript" src="/js/jquery.jcarousel.js"></script>
    <link href="/css/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css"/>
    <link href="/css/jcarousel.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="/js/common.js"></script>

    <!--[if IE 6]>
    <script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a-min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery('#mycarousel').jcarousel({
                scroll : 1
            });
        });
    </script>
</head>
<body>
<div id="wrapper">
<div class="header">
    <a href="#" class="logo" title="Обновить страницу">Администратор</a>
    <!-- .logo -->
    <ul class="logged">
        <li>Анастасия Петрова</li>
        <li><a href="#">Выйти</a></li>
    </ul>
    <ul class="going">
        <li>Перейти в</li>
        <li><a href="#">Клуб</a></li>
        <li>|</li>
        <li><a href="#">Магазин</a></li>
    </ul>
    <ul class="header_nav">
        <li><a href="#">Клуб</a></li>
        <li class="active"><a href="#">Магазин</a></li>
    </ul>
</div>
<!-- .header -->
<div class="navigation">
    <ul>
        <li><a href="#"><span>Главная</span></a></li>
        <li class="submenu active">
            <a href="#"><span>Категории</span></a>
            <ul>
                <li><a href="#"><span>Категории</span></a></li>
                <li><a href="#"><span>Пакеты свойств</span></a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><span>Товары</span></a>
            <ul>
                <li><a href="#"><span>Товары</span></a></li>
                <li><a href="#"><span>Бренды</span></a></li>
            </ul>
        </li>
        <li><a href="#"><span>Скидки</span></a></li>
        <li><a href="#"><span>Оплата</span></a></li>
        <li><a href="#"><span>Доставка</span></a></li>
        <li><a href="#"><span>Заказы</span></a></li>
    </ul>
    <div class="clear"></div>
    <!-- .clear -->
</div>
<!-- .navigation -->
<div class="content">
    
	<?php echo $content; ?>

</div>
<!-- .content -->
<div class="clear"></div>
<!-- .clear -->
<div class="empty"></div>
<!-- .empty -->
<div class="footer">
    <span>&copy; Все права защищены.</span>
</div>
<!-- .footer -->
</div>
<!-- #wrapper -->
<div style="display:none">
    <div id="addQuantity" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div class="popupQuantity">
            <form action="#">
                <h2>Добавить на склад</h2>

                <div class="input_block">
                    <p>
                        <label>Количество:</label>
                        <span class="input">
                            <input type="text" value="250 000 000" class="piece">
                            <ins>шт.</ins>
                        </span>
                    </p>

                    <p>
                        <label>Закупочная цена:</label>
                        <span class="input">
                            <input type="text" value="250 000 000.00" class="price">
                            <ins>руб.</ins>
                        </span>
                    </p>

                    <p>
                        <label>Накрутка:</label>
                        <span class="input">
                            <input type="text" value="25" class="procent">
                            <ins>%</ins>
                        </span>
                    </p>
                </div>
                <input type="button" value="Ok" class="greenGradient ok" />
                <div class="clear"></div>
                <div class="form_block">
                    <div>
                        <p>
                            <span class="label">Маржа (штука):</span>
                            <span class="input">2.56 руб.</span>
                        </p>

                        <p>
                            <span class="label">Маржа (партия):</span>
                            <span class="input">2863.36 руб.</span>
                        </p>
                    </div>
                </div>
                <input type="submit" class="greenGradient" value="Добавить" />
            </form>
        </div>
    </div>
</div>
</body>
</html>