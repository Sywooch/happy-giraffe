<?php
/* @var AttributeValueMap $attr_val
 */
?>
<div class="name">
    <p><?php echo $attr_val->map_value->value_value ?></p>
    <?php /*$this->widget('EditDeleteWidget', array(
    'modelName' => 'ProductEavText',
    'modelPk' => $attr_val->map_value->value_id,
    'attribute' => 'eav_attribute_value',
    'attributeValue' => $attr_val->map_value->value_value,
    'options' => array(
        'ondelete' => '$(this).parent().parent().remove()',
        'edit_selector' => 'p',
    )
));*/ ?>
</div>