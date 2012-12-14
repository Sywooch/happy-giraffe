<div class="entry-header">
    <?php if (!$full): ?>
        <?= CHtml::link($model->title, $model->url, array('class' => 'entry-title')); ?>
    <?php else: ?>
        <h1><?= $model->title ?></h1>
    <?php endif; ?>

    <noindex>
        <?php if ($show_user): ?>
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $model->author, 'friendButton' => true, 'location' => false)); ?>
        </div>
        <?php endif; ?>
        <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $model)); ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></div>
            <div class="views"><span class="icon"></span> <span><?=($full) ? $this->getViews() : PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $model->url), true)?></span></div>
            <div class="comments">
                <a href="#" class="icon"></a>
                <?php if ($model->getArticleCommentsCount() > 0): ?>
                <?php $lastComments = $model->lastCommentators;
                    foreach ($lastComments as $lc): ?>
                    <?php
                    $class = 'ava small';
                    if ($lc->author->gender !== null) $class .= ' ' . (($lc->author->gender) ? 'male' : 'female');
                    ?>
                    <?=HHtml::link(CHtml::image($lc->author->getAva('small')), ($lc->author->deleted)?'#':$lc->author->url, array('class' => $class), true)?>
                    <?php endforeach; ?>
                <?php if ($model->getArticleCommentsCount() > count($lastComments)): ?>
                    <?=CHtml::link('и еще ' . ($model->getArticleCommentsCount() - count($lastComments)), $model->getUrl(true))?>
                    <?php endif; ?>
                <?php else: ?>
                <?=CHtml::link('Добавить комментарий', $model->getUrl(true))?>
                <?php endif; ?>
            </div>
        </div>
    </noindex>
    <div class="clear"></div>
</div>