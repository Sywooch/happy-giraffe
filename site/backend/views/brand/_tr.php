<?php
    $cs = Yii::app()->clientScript;

    $js= "
        $('#image_upload').iframePostForm({
            json: true,
            complete: function(response) {
                if (response.status == '1')
                {
                    tr.find('div.fake_file').children().first().replaceWith($('#brand_image').tmpl({url: response.url, title: response.title}));
                }
            }
        });

        $('body').delegate('#ProductBrand_brand_image', 'change', function() {
            $(this).parents('form').submit();
            tr = $(this).parents('tr');
        });
    ";

    $cs->registerScript('brand_tr', $js);
?>

<script id="brand_image" type="text/x-jquery-tmpl">
    <img src="${url}" alt="${title}" />
</script>

<tr>
    <td class="name_ct">
        <?php
        $this->widget('EditDeleteWidget', array(
            'deleteButton'=>false,
            'model' => $brand,
            'attribute' => 'brand_title',
            'options'=> array(
                'edit_selector'=>'a',
                'edit_link_class'=>'no_child',
                'edit_link_text'=>$brand->brand_title,
            )
        ));?>
    </td>
    <td class="logo_ct">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'image_upload',
            'action' => $this->createUrl('uploadImage'),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        )); ?>
        <?php echo $form->hiddenField($brand, 'brand_id'); ?>

            <div class="fake_file">
                <?php if ($image = $brand->brand_image->getUrl('display')): ?>
                    <?php echo CHtml::image($image); ?>
                <?php else: ?>
                    <a href='#' class='add_logo fake_file' title='Загрузить логотип'> +</a>
                <?php endif; ?>
                <?php echo CHtml::activeFileField($brand, 'brand_image'); ?>
            </div>

        <?php $this->endWidget(); ?>
    </td>
    <td class="active_ct">
        <ul>
            <li><a href="#" title="Подробно о бренде">
                <img src="/images/icons/info_catg_icon.png" alt="Подробно о бренде"/></a></li>
            <li><a href="#" title="Посмотреть в магазине">
                <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
        </ul>
    </td>
    <td class="goods_ct">
        <ul>
            <li>Товаров - <a href="#"><?php echo $brand->productsCount; ?></a></li>
            <li>Категорий - <a href="#">256</a></li>
        </ul>
    </td>
    <td class="sell_ct">
        <ul>
            <li>
                <ins>Оборот</ins>
                - 23 256 789
            </li>
            <li>
                <ins>Прибыль</ins>
                - 8 363 123
            </li>
        </ul>
    </td>
    <td class="ad_ct">
        <ul>
            <li><?php $this->widget('OnOffWidget', array('model' => $brand)); ?></li>
            <li><?php $this->widget('DeleteWidget', array('model' => $brand)); ?></li>
        </ul>
    </td>
</tr>