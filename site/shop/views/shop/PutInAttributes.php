<form method="post" action="<?php echo $this->createUrl('/shop/putIn/', array_merge($_GET, array('put' => 1))) ?>" onsubmit="return addAttributesToCart(this);">
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
    <?php echo CHtml::submitButton('Добавить в корзину'); ?>
</form>