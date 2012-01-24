<?php
/* @var $this Controller
 * @var $model Attribute
 * @var $product Product
 */
$values = $product->GetCardAttributeValues($model->attribute_id);
?>
<li>
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?></p>
    </div>
    <ul class="list-elems">
        <?php foreach ($values as $attr_val): ?>
        <li>
            <?php $this->renderPartial('_attribute_value_view', array('attr_val' => $attr_val)); ?>
        </li>
        <?php endforeach; ?>
        <li>
            <input type="hidden" name="attribute_id" value="<?php echo $model->attribute_id ?>">
            <span class="add_paket" title="добавить элемент в список">+</span>
        </li>
    </ul>
</li>