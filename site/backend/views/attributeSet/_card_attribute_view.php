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
    <!--<a href="#" class="triangle<?php /*if (!$model->attribute_is_insearch) echo ' vain' */?>"></a>-->

    <p class="type"><?php echo $model->getType() ?></p>
</li>
