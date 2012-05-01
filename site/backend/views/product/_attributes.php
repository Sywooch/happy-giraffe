<?php
/* @var $this Controller
 * @var $model Product
 * @var AttributeSetMap[] $attributeMap
 */
?>
<script type="text/javascript">
    $(function () {
        $('.characteristic a.edit').click(function () {
            var block = $(this).parent();
            block.find('a').hide();
            block.find('p').show();
            block.find('a.selectBox').show();

            return false;
        });

        $('.characteristic input.set-value').click(function () {
            var block = $(this).parent().parent();
            var value = block.find('input[type=text]').val();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, value, value, block);
        });

        $('.characteristic input.set-text').click(function () {
            var block = $(this).parent().parent();
            var value = block.find('input[type=text]').val();
            var id = block.find('input[type=hidden]').val();

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("product/SetAttributeTextValue") ?>',
                data:{
                    value:value,
                    attr_id:id,
                    product_id:model_id
                },
                type:'POST',
                success:function (data) {
                    block.find('a').text(value).show();
                    block.find('p').hide();
                },
                context:block
            });
        });

        $('.characteristic input.set-yes').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, 1, 'Да', block);
        });

        $('.characteristic input.set-no').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, 0, 'Нет', block);
        });

        $('.characteristic input.set-enum').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            var value = block.find('select').val();
            var text = block.find("select option[value='" + value + "']").text();
            SetAttributeValue(id, value, text, block);
        });

        $('body').delegate('span.add_paket', 'click', function () {
            $(this).parent().append('<form class=\"input-text-add-form\" action=\"#\">' +
                '<p><input type=\"text\" value=\"\"/></p>' +
                '<p><input type=\"submit\" value=\"Ok\"/></p>' +
                '</form>');
            $(this).hide();
            return false;
        });

        $('body').delegate('form.input-text-add-form input[type=submit]', 'click', function () {
            var bl = $(this).parent('p').parent('form').parent();
            var text = bl.find('input[type=text]').val();
            var attr_id = bl.find('input[name=attribute_id]').val();

            $.ajax({
                url:'<?php echo $this->createUrl('product/AddAttrListElem', array()) ?>',
                data:{
                    value:text,
                    product_id:model_id,
                    attribute_id:attr_id
                },
                type:'POST',
                dataType:'JSON',
                success:function (data) {
                    if (data.status) {
                        bl.find('form').remove();
                        bl.find('span.add_paket').show();
                        bl.before('<li>' + data.html + '</li>');
                    }
                }
            });

            return false;
        });
    });

    function SetAttributeValue(attr_id, value, set_test, block) {
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("product/SetAttributeValue") ?>',
            data:{
                value:value,
                attr_id:attr_id,
                product_id:model_id
            },
            type:'POST',
            success:function (data) {
                block.find('a').text(set_test).show();
                block.find('p').hide();
            },
            context:block
        });
    }
</script>
<div class="propertyBlock">
    <p class="text_header">Характеристики в корзину</p>

    <div class="text_block">
        <ul class="inline_block">
            <?php foreach ($attributeMap as $attribute)
            if ($attribute->map_attribute->attribute_in_price == 1) {
                ?>
                <?php $attr = $attribute->map_attribute; ?>
                <?php $this->renderPartial('_attribute_view', array(
                    'model' => $attr,
                    'product' => $model,
                )); ?>
                <?php } ?>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<p class="text_header">Технические характеристики</p>

<table class="characteristic">

    <?php foreach ($attributeMap as $attribute) {
    if ($attribute->map_attribute->attribute_in_price != 1) {
        ?>
        <?php $attr = $attribute->map_attribute;
        if ($model->isNewRecord)
            $value = false;
        else
            $value = $model->GetAttributeValue($attr)
        ?>
<tr>
    <td class="name"><?php echo $attr->attribute_title ?></td>
        <td>
            <input type="hidden" value="<?php echo $attr->attribute_id ?>">

            <?php if ($attr->attribute_type == Attribute::TYPE_BOOL): ?>
            <p<?php if ($value !== false) echo ' style="display: none;"' ?>>
                <input type="button" class="smallGrey set-yes" value="Да"/>
                <input type="button" class="smallGrey set-no" value="Нет"/>
            </p>
            <a<?php if ($value === false) echo ' style="display: none;"' ?> href="#"
                                                                            class="edit"><?php echo $value ?></a>
            <?php endif ?>

            <?php if ($attr->attribute_type == Attribute::TYPE_ENUM): ?>
            <p<?php if ($value !== false) echo ' style="display: none;"' ?>>
                <?php echo CHtml::dropDownList('attr_value', ' ', $attr->GetEnumList(), array('empty' => ' ')); ?>
                <input type="button" class="smallGreen set-enum" value="Ok"/>
            </p>
            <a<?php if ($value === false) echo ' style="display: none;"' ?> href="#"
                                                                            class="edit"><?php echo $value ?></a>
            <?php endif ?>

            <?php if ($attr->attribute_type == Attribute::TYPE_INTG): ?>
            <p<?php if ($value !== false) echo ' style="display: none;"' ?>>
                <input type="text" value="<?php echo $value ?>"/>
                <input type="button" class="smallGreen set-value" value="Ok"/>
            </p>
            <a<?php if ($value === false) echo ' style="display: none;"' ?> href="#"
                                                                            class="edit"><?php echo $value ?></a>
            <?php endif ?>

            <?php if ($attr->attribute_type == Attribute::TYPE_TEXT): ?>
            <p<?php if ($value !== false) echo ' style="display: none;"' ?>>
                <input type="text" value="<?php echo $value ?>"/>
                <input type="button" class="smallGreen set-text" value="Ok"/>
            </p>
            <a<?php if ($value === false) echo ' style="display: none;"' ?> href="#"
                                                                            class="edit"><?php echo $value ?></a>
            <?php endif ?>

            <?php if ($attr->attribute_type == Attribute::TYPE_MEASURE): ?>
            <p<?php if ($value !== false) echo ' style="display: none;"' ?>>
                <input type="text" value=""/>
                <input type="button" class="smallGreen set-text" value="Ok"/>
            </p>
            <a<?php if ($value === false) echo ' style="display: none;"' ?> href="#"
                                                                            class="edit"><?php echo $value ?></a>
            <?php endif ?>

        </td>
        <?php
    }
} ?>
</table>
