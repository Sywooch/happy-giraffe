<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Администратор</title>

    <?php
        Yii::app()->clientScript
            ->registerCssFile('/css/reset.css')
            ->registerCssFile('/css/general.css')
            ->registerCoreScript('jquery')
            ->registerCoreScript('jquery.ui')

            ->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js')
            ->registerCssFile('/css/jquery.fancybox-1.3.4.css')

            ->registerScriptFile('/js/jquery.jcarousel.js')
            ->registerCssFile('/css/jcarousel.css')

            ->registerScriptFile('/js/jquery.selectBox.min.js')
            ->registerCssFile('/css/jquery.selectBox.css')

            ->registerScriptFile('/js/jquery.tooltip.js')

            ->registerScriptFile('/js/common.js')

            ->registerScriptFile('https://raw.github.com/jquery/jquery-tmpl/master/jquery.tmpl.min.js')
        ;
    ?>

    <!--[if IE 6]>
    <script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a-min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var confirm_popup = null;
        $(document).ready(function() {
            jQuery('#mycarousel').jcarousel({
                scroll : 1
            });
            $('#confirm_popup_link').fancybox({
                overlayColor: '#000',
                overlayOpacity: '0.6',
                padding:0,
                showCloseButton:false,
                scrolling: false
            });
        });

        $('html').delegate('#confirm_popup .popup_question input.agree', 'click', function(){
            $.fancybox.close();
            confirm_popup.callback(confirm_popup.sender);
        });

        $('html').delegate('#confirm_popup .popup_question input.disagree', 'click', function(){
            $.fancybox.close();
        });

        function ConfirmPopup(text, sender, callback)
        {
            $('#confirm_popup .popup_question span').text(text);
            $('#confirm_popup_link').trigger('click');
            this.callback = callback;
            this.sender = sender;
            confirm_popup = this;
        }

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
    <div id="fb" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div class="popup_question">
            <form action="">
                <span>Вы уверены, что хотите деактивировать<br/> категорию?</span>
                <ul>
                    <li><input type="button" class="disagree" value="Отказаться"/></li>
                    <li><input type="button" class="agree" value="Да"/></li>
                </ul>
            </form>
        </div>
    </div>
</div>

<div style="display:none">
    <div id="confirm_popup" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div class="popup_question">
            <form action="">
                <span>Вы уверены, что хотите удалить категорию?</span>
                <ul>
                    <li><input type="button" class="disagree" value="Отказаться"/></li>
                    <li><input type="button" class="agree" value="Да"/></li>
                </ul>
            </form>
        </div>
    </div>
</div>
<a id="confirm_popup_link" href="#confirm_popup"></a>

</body>
</html>