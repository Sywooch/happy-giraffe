

<?php
/* @var $this Controller
 * @var $model Attribute
 */
?>
<?php if (!isset($no_list)):?>
    <li class="set_attr_li" obj_id="<?php echo $model->attribute_id ?>">
<?php endif ?>
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?><?php if ($model->attribute_type == Attribute::TYPE_MEASURE) echo ', '.$model->measure_option->title ?></p>
        <a class="edit" href="#"></a>
        <a class="delete" href="#"></a>
    </div>
    <a href="#" class="triangle<?php if (!$model->attribute_is_insearch) echo ' vain' ?>"></a>

    <p class="type"><?php echo $model->getType() ?></p>
<?php if ($model->attribute_type == Attribute::TYPE_TEXT || $model->attribute_type == Attribute::TYPE_MEASURE): ?>
    <ul class="list-elems">
        <?php foreach ($model->value_map as $attr_val): ?>
        <li>
            <?php $this->renderPartial('_attribute_value_view',array('attr_val'=>$attr_val)); ?>
        </li>
        <?php endforeach; ?>
        <li>
            <?php $this->widget('AddWidget', array(
            'url' => $this->createUrl('AttributeSet/AddAttrListElem'),
            'model_id' => $model->attribute_id,
        ))?>
        </li>
    </ul>
<?php endif ?>
<?php if (!isset($no_list)):?>
    </li>
<?php endif ?>