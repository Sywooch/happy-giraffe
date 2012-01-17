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
    <script type="text/javascript" src="/js/jquery.selectBox.min.js"></script>
    <link href="/css/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css"/>
    <link href="/css/jquery.selectBox.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="/js/common.js"></script>

    <!--[if IE 6]>
    <script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a-min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#select1, #select2, #select3").selectBox();
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

<script type="text/javascript">
    var set_id = <?php echo $model->set_id ?>;
    $(function () {
        $('body').delegate('.add_attr', 'click', function () {
            if ($(this).hasClass('in_price'))
                var in_price = 1;
            else
                var in_price = 0;

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("pack/CreateAttribute") ?>',
                data:{in_price:in_price},
                type:'POST',
                success:function (data) {
                    $(this).hide();
                    $(this).parent('li').append(data);
                    var form = $(this).next('form');
                    form.children('p').children('select').selectBox();
                    form.children('p').children(".niceCheck").each(
                        function () {
                            changeCheckStart(jQuery(this));
                        });
                },
                context:$(this)
            });

            return false;
        });

        $('body').delegate('.attr-name a.edit', 'click', function () {
            var bl = $(this).parents('li.set_attr_li');
            var id = bl.attr('obj_id');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("pack/UpdateAttribute") ?>',
                data:{id:id},
                type:'POST',
                success:function (data) {
                    var li = $(this).parents('li.set_attr_li');
                    li.html(data);
                    var form = li.find('form');
                    form.children('p').children('select').selectBox();
                    form.children('p').children(".niceCheck").each(
                        function () {
                            changeCheckStart(jQuery(this));
                        });
                },
                context:$(this)
            });

            return false;
        });

        $('body').delegate('#attribute-form input.add_attr_btn', 'click', function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("pack/CreateAttribute") ?>',
                data:$(this).parent().parent('form').serialize() + '&set_id=' + set_id,
                type:'POST',
                dataType:'JSON',
                success:function (data) {
                    if (data !== null && data.hasOwnProperty('success'))
                        if (data.success) {
                            $.ajax({
                                url:'<?php echo Yii::app()->createUrl("pack/AttributeView") ?>',
                                data:{id:data.id},
                                type:'POST',
                                success:function (data) {
                                    $(this).parent().parent().parent().find('.add_attr').show();
                                    $(this).parent().parent().parent().before(data);
                                    $(this).parent().parent('form').find('select').selectBox('destroy');
                                    $(this).parent().parent('form').remove();
                                },
                                context:$(this)
                            });
                        }
                },
                context:$(this)
            });

            return false;
        });

        $('body').delegate('#attribute-form input.edit_attr_btn', 'click', function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("pack/UpdateAttribute") ?>',
                data:$(this).parent().parent('form').serialize() + '&set_id=' + set_id,
                type:'POST',
                dataType:'JSON',
                success:function (data) {
                    if (data !== null && data.hasOwnProperty('success'))
                        if (data.success) {
                            $.ajax({
                                url:'<?php echo Yii::app()->createUrl("pack/AttributeView") ?>',
                                data:{id:data.id},
                                type:'POST',
                                success:function (data) {
                                    $(this).parent().parent('form').find('select').selectBox('destroy');
                                    $(this).parent().parent().parent().before(data);
                                    $(this).parent().parent().parent().remove();
                                },
                                context:$(this)
                            });
                        }
                },
                context:$(this)
            });

            return false;
        });

        $('body').delegate('.attr-name .delete', 'click', function () {
            var answer = confirm('Точно удалить?');
            if (answer) {
                var bl = $(this).parents('li.set_attr_li');
                var id = bl.attr('obj_id');
                var class_name = 'Attribute';

                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("ajax/delete") ?>',
                    data:{
                        class:class_name,
                        id:id
                    },
                    type:'GET',
                    success:function (data) {
                        if (data == '1') {
                            bl.remove();
                        }
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('body').delegate('a.triangle', 'click', function () {
            var attr_id = $(this).parent('li').attr('obj_id');
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("pack/attributeInSearch") ?>',
                data:'id=' + attr_id,
                type:'GET',
                success:function (data) {
                    if (data == '1')
                        $(this).toggleClass('vain');
                },
                context:$(this)
            });

            return false;
        });

        $('body').delegate('#Attribute_attribute_type', 'change', function () {
            if ($(this).val() == <?php echo Attribute::TYPE_MEASURE ?>) {
                $(this).parent().parent().find('p').show();
            } else{
                $(this).parent().next('p').hide();
                $(this).parent().next('p').next('p').hide();
            }

        });

        $('body').delegate('#attribute_measure', 'change', function () {
            if ($('#attribute_measure').val() != '')
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("pack/GetMeasureOptions") ?>',
                    data:{id:$('#attribute_measure').val()},
                    type:'POST',
                    success:function (data) {
                        $('#Attribute_measure_option_id').html(data);
                        $('#Attribute_measure_option_id').selectBox('refresh');
                    },
                    context:$(this)
                });
        });

    });
</script>
<?php
/**
 * @var AttributeSet $model
 */
?>
<div class="content">
    <div class="centered">

        <h1>Пакет свойств - <?php echo $model->set_title ?></h1>

        <p class="text_header">Название</p>

        <div class="text_block">
            <p>Бренд</p>
        </div>

        <p class="text_header">Описание</p>

        <div class="text_block">

        </div>

        <p class="text_header">Цена</p>

        <div class="text_block">
            <ul class="inline_block">
                <?php foreach ($model->set_map as $attribute): ?>
                <?php $attr = Attribute::model()->findByPk($attribute->map_attribute_id); ?>
                <?php if ($attr->attribute_in_price) $this->renderPartial('_attribute_view', array('model' => $attr)); ?>
                <?php endforeach; ?>
                <li>
                    <span class="add_paket add_attr in_price" title="Добавить характеристику">+</span>
                </li>
            </ul>
            <div class="clear"></div>
        </div>

        <p class="text_header">Характеристики</p>
        <?php $attributes = $model->set_map ?>

        <div class="text_block">
            <ul class="inline_block">
                <?php foreach ($model->set_map as $attribute): ?>
                <?php $attr = Attribute::model()->findByPk($attribute->map_attribute_id); ?>
                <?php if (!$attr->attribute_in_price) $this->renderPartial('_attribute_view', array('model' => $attr)); ?>
                <?php endforeach; ?>
                <li>
                    <span class="add_paket add_attr" title="Добавить характеристику">+</span>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <!-- .centered -->
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
    <div id="delete_attribute" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div class="popup_question">
            <form action="">
                <span>Вы уверены, что хотите удалить характеристику?</span>
                <ul>
                    <li><input type="button" class="disagree" value="Отказаться"/></li>
                    <li><input type="button" class="agree" value="Да"/></li>
                </ul>
            </form>
        </div>
    </div>
</div>
</body>
</html>