<?php
/**
 * @var CommunityContent[] $contents
 */
?>

<div class="fast-articles2 js-fast-articles2">
    <div class="fast-articles2_t-ico"></div>
    <div class="fast-articles2_t">Популярные записи</div>
    <?php foreach ($contents as $b): ?>
        <?php Yii::app()->controller->renderPartial('blog.views.default._popular_one', compact('b')); ?>
    <?php endforeach; ?>
</div>