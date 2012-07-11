<?php
/* @var $this Controller
 * @var $name Name
 */
?>
<div class="name_bold variants clearfix">Варианты имени:</div>
<input type="hidden" value="NameOption" name="modelName">
    <?php foreach ($name->nameOptions as $value): ?>
        <?php $this->renderPartial('_item_view',array('model'=>$value)); ?>
    <?php endforeach; ?>
<a href="#" class="add small">+</a>