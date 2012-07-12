<?php
/* @var $this Controller
 * @var $name Name
 */
?>
<div class="name_bold variants clearfix">Подходящие отчества к имени:</div>
<input type="hidden" value="NameMiddle" name="modelName">
    <?php foreach ($name->nameMiddles as $value): ?>
        <?php $this->renderPartial('_item_view',array('model'=>$value)); ?>
    <?php endforeach; ?>
<a href="#" class="add small">+</a>