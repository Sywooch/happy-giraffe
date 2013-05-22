<?php
/**
 * @var $list Notification[]
 * @var $check bool
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<?php foreach ($list as $model) :?>
<div class="user-notice-list_i">
    <?php $this->renderPartial('types/type_' . $model->type, compact('model', 'check')); ?>
</div>
<?php endforeach; ?>