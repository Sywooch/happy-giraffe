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
            'model' => $good,
            'attribute' => 'product_title',
            'options'=> array(
                'edit_selector'=>'a',
                'edit_link_class'=>'no_child',
                'edit_link_text'=>$good->product_title,
            )
        ));?>
    </td>
    <td class="logo_ct">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Product[product_image]',
            'action' => $this->createUrl('UploadBigPhoto'),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        )); ?>
        <?php echo $form->hiddenField($good, 'product_id'); ?>

            <div class="fake_file">
                <?php if ($image = $good->product_image->getUrl('display')): ?>
                    <?php echo CHtml::image($image); ?>
                <?php else: ?>
                    <a href='#' class='add_logo fake_file' title='Загрузить фото'> +</a>
                <?php endif; ?>
                <?php echo CHtml::activeFileField($good, 'product_image'); ?>
            </div>

        <?php $this->endWidget(); ?>
    </td>
    <td class="active_ct">
        <ul>
            <li><a href="<?php echo $this->createUrl('update', array('product_id'=>$good->product_id)) ?>"
                   title="Подробно о товаре" target="_blank">
                <img src="/images/icons/info_catg_icon.png" alt="Подробно о товаре"/></a></li>
            <li><a href="<?php echo Yii::app()->params['main_site'].'product/'.$good->product_id ?>"
                   title="Посмотреть в магазине" target="_blank">
                <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
        </ul>
    </td>
    <td class="sell_ct">
        <ul>
            <li>
                <ins>Оборот</ins>
                - 0
            </li>
            <li>
                <ins>Прибыль</ins>
                - 0
            </li>
        </ul>
    </td>
    <td class="ad_ct">
        <ul>
            <li><?php $this->widget('DeleteWidget', array('model' => $good)); ?></li>
        </ul>
    </td>
</tr>