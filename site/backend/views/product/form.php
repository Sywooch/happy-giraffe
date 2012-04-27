<?php
/* @var $this Controller
 * @var $model Product
 * @var Category $category
 * @var AttributeSetMap[] $attributeMap
 */
Yii::app()->clientScript
    ->registerCoreScript('jquery')
    ->registerCoreScript('jquery.ui')
    ->registerCssFile('/css/jquery.ui/slider.css');

$image = $model->isNewRecord ? 0 : $model->main_image ? $model->main_image->photo->getPreviewUrl(329, 355, Image::WIDTH) : 0;
?>
<script type="text/javascript">
var model_id = <?php echo ($model->isNewRecord) ? 'null' : $model->product_id ?>;
var category_id = <?php echo $category->category_id ?>;
var has_image = <?php echo (int)is_string($image); ?>;

$(function () {
//        $("#filter-price-1").slider({
//            range:true,
//            min:0,
//            max:60000,
//            values:[0, 60000],
//            slide:function (event, ui) {
//                $("#filter-price-1-min").val(ui.values[0]);
//                $("#filter-price-1-max").val(ui.values[1]);
//            }
//        });
    $('select').selectBox();

    $("#filter-price-1-min").val($("#filter-price-1").slider("values", 0));
    $("#filter-price-1-max").val($("#filter-price-1").slider("values", 1));


    $('div.editProduct > div.name input[type=button]').click(function () {
        var title = $(this).prev().val();
        if (title != '') {
            if (model_id == null)
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("product/create") ?>',
                    data:{title:title, category_id:category_id},
                    type:'GET',
                    dataType:'JSON',
                    success:function (data) {
                        if (data.success) {
                            $('div.editProduct > div').show();
                            model_id = data.id;
                            $('input[name="Product[product_id]"]').val(model_id);

                            $(this).parent().hide();
                            $(this).parent().prev().text(title);
                            $(this).parent().prev().show();
                            $('select').selectBox('refresh');
                        }
                    },
                    context:$(this)
                });
            else {
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                    data:{
                        modelPk:model_id,
                        attribute:'product_title',
                        modelName:'Product',
                        value:title
                    },
                    type:'POST',
                    success:function (data) {
                        $(this).parent().hide();
                        $(this).parent().prev().text(title);
                        $(this).parent().prev().show();
                    },
                    context:$(this)
                });
            }
        }
    });

    $('.description h2.edit').click(function () {
        $(this).next().show();
        $(this).next().next().hide();

        return false;
    });

    $('#descr-update').click(function () {
        var text = $(this).prev().prev().val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
            data:{
                modelPk:model_id,
                attribute:'product_text',
                modelName:'Product',
                value:text
            },
            type:'POST',
            success:function (data) {
                if (data) {
                    $(this).parent().hide();
                    $(this).parent().parent().find('div.pd-text').text(text);
                    $(this).parent().parent().find('div.pd-text').show();
                }
            },
            context:$(this)
        });
    });

    $('#descr-cancel').click(function () {
        if (model_id != null) {
            $(this).parent().hide();
            $(this).parent().next().show();
        }
    });

    $('.brand_add .edit-brand').click(function () {
        $(this).hide();
        $(this).prev().hide();
        $(this).prev().prev().show();
        return false;
    });

    $('.brand_add .set-brand').click(function () {
        var brand_id = $(this).parent().find('select').val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("product/setBrand") ?>',
            data:{product_id:model_id, brand_id:brand_id},
            type:'POST',
            dataType:'JSON',
            success:function (data) {
                if (data.success) {
                    $(this).parent().parent().find('img').attr("src", data.image);
                    $(this).parent().parent().find('span.brand-title').text(data.name);
                    $(this).parent().hide();
                    $(this).parent().parent().find('img').show();
                    $(this).parent().parent().find('a').show();
                }
            },
            context:$(this)
        });

        return false;
    });

    $('.sex .all').click(function () {
        if (!$(this).hasClass('active')) SetGender(0, $(this));
        return false;
    });
    $('.sex .boys').click(function () {
        if (!$(this).hasClass('active')) SetGender(1, $(this));
        return false;
    });
    $('.sex .girls').click(function () {
        if (!$(this).hasClass('active')) SetGender(2, $(this));
        return false;
    });

    $('.filter-box .slider-values a.edit').click(function () {
        $(this).prev().show();
        $(this).hide();
        return false;
    });

    $('.set-ageRange').click(function () {
        var age_from = $("#age_from").val();
        var age_to = $("#age_to").val();
        var age_interval = $("#age_interval").val();

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("product/SetAge") ?>',
            data:{
                id:model_id,
                age_from:age_from,
                age_to:age_to,
                age_interval:age_interval
            },
            type:'POST',
            dataType:'JSON',
            success:function (result) {
                if (result.status) {
                    $(this).parent().hide();
                    $(this).parent().next().show();
                    $(this).parent().next().text(result.text);
                }
            },
            context:$(this)
        });

        return false;
    });

    $('h1.edit').click(function () {
        $(this).hide();
        $(this).next().show();

        return false;
    });

    $('.photo-upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status == '1') {
                $('.big_foto a').replaceWith($('#product_image').tmpl({url:response.url, title:response.title}));
                if (!has_image) $('p.total ins').text(parseInt($('p.total ins').text()) + 1);
                has_image = 1;
            }
        }
    });

    $('body').delegate('#Product_product_image, #ProductImage_image_file', 'change', function () {
        $(this).parents('form').submit();
    });

    $('body').delegate('div.video > a.add', 'click', function (e) {
        e.preventDefault();
        $('#add_video').dialog('open');
    });

    $('body').delegate('#add_video > form', 'submit', function (e) {
        e.preventDefault();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:$(this).attr('action'),
            data:$(this).serialize(),
            success:function (response) {
                $('#add_video').dialog('close');
                if (response.status == '1') {
                    $('div.videos').append(response.video);
                    $(this).children('input[name="video_url"]').val('http://');
                }
            },
            context:$(this)
        });
    });
});

function SetGender(value, sender) {
    $.ajax({
        url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
        data:{
            modelPk:model_id,
            attribute:'product_sex',
            modelName:'Product',
            value:value
        },
        type:'POST',
        success:function (data) {
            sender.parent().find('a').removeClass('active');
            sender.addClass('active');
        },
        context:sender
    });
}
</script>

<script id="product_image" type="text/x-jquery-tmpl">
    <a href="#">
        <span>
            <?php echo CHtml::image('${url}', '${title}'); ?>
        </span>
    </a>
</script>

<script id="product_small_image" type="text/x-jquery-tmpl">
    <li>
        <?php
        $this->widget('DeleteWidget', array(
            'modelName' => 'ProductImage',
            'modelPk' => '${modelPk}',
            'selector' => 'li',
            'onSuccess' => "$('p.total ins').text(parseInt($('p.total ins').text()) - 1);",
        ));
        ?>
        <p>
            <span>
                <?php echo CHtml::image('${url}'); ?>
            </span>
        </p>
    </li>
</script>

<div class="bodyr">
    <div class="right">
        <a href="<?php echo $this->createUrl('product/index') ?>" class="all_products">Список товаров</a>
        <a href="<?php echo $this->createUrl('product/index', array('category_id' => $category->category_id)) ?>"
           class="all_products">Список товаров этой категории</a>
    </div>
    <div class="center">
        <div class="editProduct">
            <?php if ($model->isNewRecord): ?>
            <h1 class="edit" style="display: none;"></h1>
            <?php else: ?>
            <h1 class="edit"><?php echo $model->product_title ?></h1>
            <?php endif ?>
            <div class="name"<?php if (!$model->isNewRecord) echo 'style="display: none;"' ?>>
                <input type="text" class="h1" value="<?php echo $model->product_title ?>"/>
                <input type="button" class="greenGradient" value="Ok"/>

                <div class="clear"></div>
            </div>

            <div<?php if ($model->isNewRecord) echo ' style="display: none;"' ?>>
                <div class="one_product">
                    <div class="big_foto fake_file">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'big_foto_upload',
                        'action' => $this->createUrl('uploadPhoto'),
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'class' => 'photo-upload'
                        ),
                    )); ?>
                        <?php echo $form->hiddenField($model, 'product_id'); ?>
                        <?php if ($image): ?>
                        <a href="#">
                                <span>
                                    <?php echo CHtml::image($image, $model->product_title); ?>
                                </span>
                        </a>
                        <?php else: ?>
                        <a href="#" class="add addValue" title="Загрузить фото">
                                <span>
                                    Загрузите <ins>фото</ins> товара
                                </span>
                        </a>
                        <?php endif; ?>
                        <?php echo CHtml::activeFileField($model, 'product_image'); ?>
                        <?php echo CHtml::hiddenField('type', 1); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                    <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'small_foto_upload',
                    'action' => $this->createUrl('uploadPhoto'),
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'class' => 'photo-upload'
                    ),
                )); ?>
                    <?php echo $form->hiddenField($model, 'product_id'); ?>
                    <ul id="mycarousel" class="small_foto">
                        <li class="fake_file">
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                            <?php echo CHtml::activeFileField($model, 'product_image'); ?>
                            <?php echo CHtml::hiddenField('type', 0); ?>
                        </li>
                        <?php foreach ($model->images as $i): ?>
                        <li>
                            <?php
                            $this->widget('DeleteWidget', array(
                                'model' => $i,
                                'selector' => 'li',
                                'onSuccess' => "$('p.total ins').text(parseInt($('p.total ins').text()) - 1);",
                            ));
                            ?>

                            <p>
                                <span>
                                    <?php echo CHtml::image($i->photo->getPreviewUrl(76, 79, Image::WIDTH)); ?>
                                </span>
                            </p>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php $this->endWidget(); ?>
                    <p class="total">Всего фото:
                        <ins><?php echo (int)is_string($image) + count($model->images); ?></ins>
                    </p>
                </div>

                <div class="brand_add">
                    <span
                        class="brand-title"><?php echo (empty($model->product_brand_id)) ? 'Brand' : $model->brand->brand_title ?></span>
                    <span
                        style="padding-top:15px;float: left;<?php if (!empty($model->product_brand_id)) echo 'display: none;' ?>">
                        <?php echo CHtml::dropDownList('brand_id', ' ',
                        CHtml::listData(ProductBrand::model()->findAll(), 'brand_id', 'brand_title'), array('empty' => ' ')); ?>
                        <input type="button" class="smallGreen set-brand" value="Ok"/>
                    </span>

                    <img style="float: left;<?php if (empty($model->product_brand_id)) echo 'display: none;' ?>"
                         src="<?php if (!empty($model->product_brand_id)) echo $model->brand->brand_image->getUrl()  ?>"
                         alt="">
                    <a<?php if (empty($model->product_brand_id)) echo ' style="display: none;"' ?> class="edit-brand"
                                                                                                   href="#">Изм.</a>
                </div>

                <div class="description">
                    <h2 class="edit">Описание товара</h2>

                    <div class="pd-form"<?php if (!empty($model->product_text)) echo ' style="display:none;" ' ?>>
                        <textarea rows="20" cols="10"><?php echo $model->product_text ?></textarea>
                        <input type="button" class="greyGradient" id="descr-cancel" value="Отменить"/>
                        <input type="button" class="greenGradient" id="descr-update" value="Ok"/>
                    </div>
                    <div class="pd-text"<?php if (empty($model->product_text)) echo ' style="display:none;"' ?>><?php
                        echo $model->product_text ?></div>
                </div>

                <div class="clear"></div>

                <div class="quantity">
                    <div class="left_quantity">
                        <p>Количество на складе</p>

                        <p class="number"><span>0</span> шт.</p>
                        <?php echo CHtml::link('Добавить на склад', array('/product/putIn', 'id' => $model->primaryKey), array('class' => 'greenGradient fancy')); ?>
                    </div>
                    <div class="right_quantity">
                    </div>
                    <div class="clear"></div>
                </div>

                <?php $this->renderPartial('_attributes', array(
                'attributeMap' => $attributeMap,
                'model' => $model
            )); ?>

                <p class="text_header">Видео о товаре</p>

                <div class="videos">
                    <?php foreach ($model->videos as $v): ?>
                    <?php $this->renderPartial('_video', array(
                        'model' => $v,
                    )); ?>
                    <?php endforeach; ?>
                </div>

                <div class="video add">
                    <a href="#" class="add addValue" title="Добавить видео"></a>
                </div>

                <div class="clear"></div>

                <p class="text_header">Дополнительно</p>

                <?php if ($category->HasAgeFilter()): ?>
                <div class="filter-box">
                    <div class="filter-slider">
                        <div class="slider-values">
                            <span class="name">По возрасту</span>
                            <?php $value = $model->GetAgeRangeText(); ?>
                            <span<?php if (!empty($value)) echo ' style="display: none;"' ?>>
                            С <?php echo CHtml::dropDownList('age_from', '', HDate::Range(0, 18), array('empty' => ' ', 'id' => 'age_from')); ?>
                              До  <?php echo CHtml::dropDownList('age_to', '', HDate::Range(0, 18), array('empty' => ' ', 'id' => 'age_to')); ?>
                                <?php echo CHtml::dropDownList('age_interval', '', array('1' => 'месяцев', '2' => 'лет'), array('id' => 'age_interval')); ?>
                                <input type="button" class="smallGreen set-ageRange" value="Ok"/>
                        </span>
                            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#"
                                                                                         class="edit"><?php echo $value ?></a>
                        </div>
                        <div class="year_old" style="display: none;">
                            <p class="first_year">Первый год жизни</p>

                            <p class="nursery">Ясельный возраст</p>

                            <p class="preschool">Дошкольный возраст</p>

                            <p class="student">Младший школьник</p>

                            <p class="teenager">Подросток</p>

                            <p class="young">Юношеский возраст</p>

                            <div class="clear"></div>
                        </div>
                        <div class="slider-in" style="display: none;">
                            <div id="filter-price-1"></div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <?php if ($category->HasSexFilter()): ?>
                <div class="sex">
                    <p class="name">По полу</p>
                    <a class="all<?php if ($model->product_sex === 0) echo ' active' ?>" href="#">Всем</a>
                    <a class="boys<?php if ($model->product_sex == 1) echo ' active' ?>" href="#">Мальчики</a>
                    <a class="girls<?php if ($model->product_sex == 2) echo ' active' ?>" href="#">Девочки</a>

                    <div class="clear"></div>
                </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'add_video',
    'options' => array(
        'title' => 'Добавить видео',
        'autoOpen' => false,
    ),
));
?>
<?php echo CHtml::beginForm('/product/addVideo', 'post'); ?>
<?php echo CHtml::hiddenField('product_id', $model->primaryKey); ?>
URL: <?php echo CHtml::textField('video_url', 'http://'); ?>
<?php echo CHtml::submitButton('Добавить'); ?>
<?php echo CHtml::endForm(); ?>
<?
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
