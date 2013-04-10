<div class="entry-header">
    <?php if (!$full): ?>
        <div class="entry-title_hold">
            <a class="entry-title" href="<?=$model->url ?>"><?=$model->title ?></a>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $model)); ?>
        </div>
    <?php else: ?>
        <h1><?= $model->title ?><?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $model)); ?></h1>
    <?php endif; ?>

    <?php if (Yii::app()->controller->route == 'community/view'): ?>

    <?php endif; ?>

    <noindex>
        <?php if ($show_user): ?>
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $model->author, 'friendButton' => true, 'location' => false)); ?>
        </div>
        <?php endif; ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></div>
            <div class="views"><span class="icon"></span> <span><?=($full) ? $this->getViews() : PageView::model()->viewsByPath($model->url)?></span></div>
            <div class="comments">
                <a href="#" class="icon"></a>
                <?php if ($model->getUnknownClassCommentsCount() > 0): ?>
                <?php $lastComments = $model->lastCommentators;
                    foreach ($lastComments as $lc): ?>
                    <?php
                    $class = 'ava small';
                    if ($lc->author->gender !== null) $class .= ' ' . (($lc->author->gender) ? 'male' : 'female');
                    ?>
                    <?=HHtml::link(CHtml::image($lc->author->getAva('small')), ($lc->author->deleted)?'#':$lc->author->url, array('class' => $class), true)?>
                    <?php endforeach; ?>
                <?php if ($model->getUnknownClassCommentsCount() > count($lastComments)): ?>
                    <?=CHtml::link('и еще ' . ($model->getUnknownClassCommentsCount() - count($lastComments)), $model->getUrl(true))?>
                    <?php endif; ?>
                <?php else: ?>
                <?=CHtml::link('Добавить комментарий', $model->getUrl(true))?>
                <?php endif; ?>
            </div>
        </div>
    </noindex>
    <div class="clear"></div>
</div>