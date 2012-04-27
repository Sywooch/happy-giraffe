<form method="post" action="<?php echo $this->createUrl('/product/putIn/', array_merge($_GET, array('put' => 1))) ?>" id="put-form">
    <?php foreach($attributes as $attribute): ?>
    <p>
        <?php echo $attribute['attribute']->map_attribute->attribute_title; ?>:&nbsp;
        <?php if(
                    $attribute['attribute']->map_attribute->attribute_type == Attribute::TYPE_ENUM ||
                    $attribute['attribute']->map_attribute->attribute_type == Attribute::TYPE_INTG ||
                    $attribute['attribute']->map_attribute->attribute_type == Attribute::TYPE_MEASURE ||
                    $attribute['attribute']->map_attribute->attribute_type == Attribute::TYPE_TEXT
            ): ?>
            <?php echo CHtml::dropDownList('Attribute['.$attribute['attribute']->map_attribute->attribute_id.']', '', $attribute['items']); ?>
        <?php elseif($attribute['attribute']->map_attribute->attribute_type == Attribute::TYPE_BOOL): ?>
            <?php echo CHtml::checkBoxList('Attribute['.$attribute['attribute']->map_attribute->attribute_id.']', '', $attribute['items']) ?>
        <?php endif; ?>
    </p>
    <?php endforeach; ?>
    <p>Количество: <input type="text" name="count" value="1" /></p>
    <?php echo CHtml::submitButton('Добавить в корзину'); ?>
</form>
<script type="text/javascript">
    $('#put-form').iframePostForm({
        complete : function(data) {

        }
    });
</script>