<?php
/* @var $this Controller
 * @var $model Attribute
 */
?>
<?php if (!isset($no_list)):?>
    <li class="set_attr_li" obj_id="<?php echo $model->attribute_id ?>">
<?php endif ?>
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?></p>
        <a class="edit" href="#"></a>
        <a class="delete" href="#"></a>
    </div>
    <a href="#" class="triangle<?php if (!$model->attribute_is_insearch) echo ' vain' ?>"></a>

    <p class="type"><?php echo $model->getType() ?></p>
<?php if ($model->attribute_type == Attribute::TYPE_ENUM): ?>
    <ul class="list-elems">
        <?php foreach ($model->value_map as $attr_val): ?>
        <li>
            <?php $this->widget('SimpleFormInputWidget', array(
            'model' => $attr_val->map_value,
            'attribute' => 'value_value'
        ))?>
        </li>
        <?php endforeach; ?>
        <li>
            <?php $this->widget('SimpleFormAddWidget', array(
            'url' => $this->createUrl('pack/AddAttrListElem'),
            'model_id' => $model->attribute_id,
        ))?>
        </li>
    </ul>
<?php endif ?>
<?php if (!isset($no_list)):?>
    </li>
<?php endif ?>