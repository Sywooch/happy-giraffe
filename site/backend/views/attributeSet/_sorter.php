<?php
/* @var $this Controller
 * @var $model AttributeSet
 * @var AttributeSetMap $attribute
 */

$brand_showed = false;
?>
<div class="filter_header">
    <span>Фильтр</span>-порядок
</div>
<ul id="sortable">
    <?php foreach ($model->set_map as $attribute): ?>
    <?php if (!$brand_showed && $attribute->pos > $model->brand_pos): ?>
        <?php $brand_showed = true; ?>
        <li class="sort-elem">
            <div class="drop"></div>
            <p>Бренд</p>
            <input type="hidden" name="id" value="brand">
        </li>
    <?php endif ?>
    <li class="sort-elem">
        <div class="drop"></div>
        <p><?php echo $attribute->map_attribute->attribute_title ?></p>
        <input type="hidden" name="id" value="<?php echo $attribute->map_attribute_id ?>">
    </li>
    <?php endforeach; ?>
    <?php if (!$brand_showed): ?>
    <li class="sort-elem">
        <div class="drop"></div>
        <p>Бренд</p>
        <input type="hidden" name="id" value="brand">
    </li>
    <?php endif ?>
</ul>