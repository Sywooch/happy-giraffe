<?php
/* @var $this Controller
 * @var $model Attribute
 */
?>
<div class="attr" attr_id="<?php echo $model->id ?>">
    <div class="name">
        <p>Цена</p>
        <a class="edit" href="#"></a>
        <a class="delete" href="#"></a>
    </div>
    <p class="triangle"></p>

    <p class="type"><?php echo $model->getType() ?></p>
</div>