<?php
/* @var $this Controller
 * @var $name Name
 */
?>
<div class="name_bold variants clearfix">Ласковое обращение:</div>
<input type="hidden" value="NameSweet" name="modelName">
    <?php foreach ($name->nameSweets as $value): ?>
        <?php $this->renderPartial('_item_view',array('model'=>$value)); ?>
    <?php endforeach; ?>
<a href="#" class="add small">+</a>