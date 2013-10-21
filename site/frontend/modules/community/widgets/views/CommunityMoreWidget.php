<?php
/**
 * @var CommunityContent[] $posts
 */
?>

<?php if ($posts): ?>
    <div class="such-post">
        <div class="such-post_title">Смотрите также</div>
        <div class="clearfix">
            <?php foreach ($posts as $post): ?>
                <?php Yii::app()->controller->renderPartial('community.widgets.views._clubFavourite.' . ($post->type_id == 3 ? 'photoPost' : 'post'), compact('post')); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>