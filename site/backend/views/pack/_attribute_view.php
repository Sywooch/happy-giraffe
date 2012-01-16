<?php
/* @var $this Controller
 * @var $model Attribute
 */
?>
<li class="set_attr_li" obj_id="<?php echo $model->attribute_id ?>">
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?></p>
        <a class="edit" href="#"></a>
        <a class="delete" href="#"></a>
    </div>
    <p class="triangle<?php if (!$model->attribute_is_insearch) echo ' vain' ?>"></p>

    <p class="type"><?php echo $model->getType() ?></p>
<?php if ($model->attribute_type == Attribute::TYPE_ENUM): ?>
    <ul class="list-elems">
        <li>
            <?php $this->widget('SimpleFormAddWidget', array(
            'url' => $this->createUrl('pack/AddAttrListElem'),
            'model_id' => $model->attribute_id,
        ))?>
        </li>
    </ul>
<?php endif ?>
</li>