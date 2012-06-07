<?php
/* @var $this Controller
 * @var $model Attribute
 * @var $product Product
 */
?>
<li>
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?><?php if ($model->attribute_in_price && $model->attribute_type == Attribute::TYPE_MEASURE) echo ', '.$model->measure_option->title ?></p>
    </div>
    <ul class="list-elems">
        <?php foreach ($model->value_map as $attr_val): ?>
        <li>
            <?php $this->renderPartial('_attribute_value_view', array('attr_val' => $attr_val)); ?>
        </li>
        <?php endforeach; ?>
    </ul>
</li>