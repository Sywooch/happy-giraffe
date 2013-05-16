<?php
/**
 * @var $model NotificationLike
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<div><?=$model->count ?></div>
<?= HDate::GetFormattedTime($model->updated) ?>
<?php foreach ($model->articles as $article): ?>
    <div><?=$article['entity'] ?> - <?=$article['entity_id'] ?> - <?=$article['count'] ?></div>
<?php endforeach; ?>