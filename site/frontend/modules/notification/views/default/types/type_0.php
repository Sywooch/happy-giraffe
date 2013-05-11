<?php
/**
 * @var $model NotificationUserContentComment
 */
?>
<div>
    <div>Комментарий к вашей статье <?=$model->getEntity()->title ?></div>
    <div><a href="javascript:;" onclick="UserNotification.read(this, '<?=$model->_id ?>')">прочитал</a></div>
</div>