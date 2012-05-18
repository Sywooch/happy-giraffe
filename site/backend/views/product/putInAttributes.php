<form method="post" action="<?php echo $this->createUrl('/product/putIn/', array_merge($_GET, array('put' => 1))) ?>" id="put-form">
    <?php foreach($model->category->attributesMap as $attribute): ?>
    <?php if ($attribute->map_attribute->attribute_in_price == 1): ?>
    <?php $attr = $attribute->map_attribute; ?>
    <p>
        <?php echo $attr->attribute_title; ?>:&nbsp;
        <?php if(
                    $attr->attribute_type == Attribute::TYPE_ENUM ||
                    $attr->attribute_type == Attribute::TYPE_INTG ||
                    $attr->attribute_type == Attribute::TYPE_MEASURE ||
                    $attr->attribute_type == Attribute::TYPE_TEXT
            ): ?>
            <?php echo CHtml::dropDownList('Attribute['.$attr->attribute_id.']', '', CHtml::listData($attr->value_map, 'map_value.value_id', 'map_value.value_value')); ?>
            <?php /*echo CHtml::dropDownList('Attribute['.$attribute['attribute']->map_attribute->attribute_id.']', '', $attribute['items']); */?>
        <?php elseif($attr->attribute_type == Attribute::TYPE_BOOL): ?>
            <?php echo CHtml::checkBox('Attribute['.$attr->attribute_id.']', '') ?>
        <?php endif; ?>
    </p>
    <?php endif; ?>
    <?php endforeach; ?>
    <p>Количество: <input type="text" name="count" value="1" /></p>
    <p>Стоимость (шт): <input type="text" name="price" id="product_put_price" value="" /></p>
    <?php echo CHtml::submitButton('Добавить в корзину'); ?>
</form>
<script type="text/javascript">
    $('#put-form').iframePostForm({
        complete : function(data) {
            $('#product-items-count').text(data);
            $.fancybox.close();
        }
    });
</script>