<?php
/* @var array $attr_val
 */
?>
<div class="name">
    <p><?php echo $attr_val['eav_attribute_value'] ?></p>
    <?php $this->widget('EditDeleteWidget', array(
    'modelName' => 'ProductEavText',
    'modelPk' => $attr_val['eav_id'],
    'attribute' => 'eav_attribute_value',
    'attributeValue' => $attr_val['eav_attribute_value'],
    'options' => array(
        'ondelete' => '$(this).parent().parent().remove()',
        'edit_selector' => 'p',
    )
)); ?>
</div>