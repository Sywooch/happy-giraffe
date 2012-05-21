<?php
/* @var AttributeValueMap $attr_val
 */
?>
<div class="name">
    <p><?php echo $attr_val->map_value->value_value ?></p>
    <?php $this->widget('EditDeleteWidget', array(
    'model' => $attr_val,
    'attribute' => 'value_value',
    'options'=>   array(
        'ondelete'=>'$(this).parent().parent().remove()',
        'edit_selector'=>'p',
    )
)); ?>
</div>