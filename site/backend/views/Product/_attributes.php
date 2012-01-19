<?php
/* @var $this Controller
 * @var $model Product
 * @var AttributeSetMap[] $attributeMap
 */
?>
<?php foreach ($attributeMap as $attribute): ?>
<?php $attr = $attribute->map_attribute;
$value = $model->GetAttributeValue($attr) ?>
    <tr>
        <td class="name"><?php echo $attr->attribute_title ?></td>
        <td>
            <input type="hidden" value="<?php echo $attr->attribute_id ?>">

<?php if ($attr->attribute_type == Attribute::TYPE_BOOL): ?>
            <p<?php if ($value !== null) echo ' style="display: none;"' ?>>
                <input type="button" class="smallGrey set-yes" value="Да"/>
                <input type="button" class="smallGrey set-no" value="Нет"/>
            </p>
            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#" class="edit"><?php echo $value ?></a>
    <?php endif ?>

<?php if ($attr->attribute_type == Attribute::TYPE_ENUM): ?>
            <p<?php if ($value !== null) echo ' style="display: none;"' ?>>
        <?php echo CHtml::dropDownList('attr_value', ' ', $attr->GetEnumList(), array('empty' => ' ')); ?>
        <input type="button" class="smallGreen set-enum" value="Ok"/>
    </p>
            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#" class="edit"><?php echo $value ?></a>
    <?php endif ?>

<?php if ($attr->attribute_type == Attribute::TYPE_INTG): ?>
            <p<?php if ($value !== null) echo ' style="display: none;"' ?>>
        <input type="text" value="<?php echo $value ?>"/>
        <input type="button" class="smallGreen set-value" value="Ok"/>
    </p>
            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#" class="edit"><?php echo $value ?></a>
    <?php endif ?>

<?php if ($attr->attribute_type == Attribute::TYPE_TEXT): ?>
            <p<?php if ($value !== null) echo ' style="display: none;"' ?>>
        <input type="text" value="<?php echo $value ?>"/>
        <input type="button" class="smallGreen set-text" value="Ok"/>
    </p>
            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#" class="edit"><?php echo $value ?></a>
    <?php endif ?>

<?php if ($attr->attribute_type == Attribute::TYPE_MEASURE): ?>
            <p<?php if ($value !== null) echo ' style="display: none;"' ?>>
        <input type="text" value=""/>
        <input type="button" class="smallGreen" value="Ok"/>
    </p>
            <a<?php if (empty($value)) echo ' style="display: none;"' ?> href="#" class="edit"><?php echo $value ?></a>
    <?php endif ?>

</td>
<?php endforeach; ?>