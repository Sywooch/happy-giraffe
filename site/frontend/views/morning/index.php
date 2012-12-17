<?php
/* @var $this Controller
 * @var $articles CommunityContent[]
 */
if (!$empty_param)
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>
<?php if (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('editMorning')):?>
<div class="club-fast-add clearfix">
    <a class="btn btn-green" href="<?=$this->createUrl('/morning/edit') ?>"><span><span>Добавить</span></span></a>
</div>
<div class="club-fast-add clearfix">
    <a class="btn btn-green" href="<?=$this->createUrl('/morning/publicAll') ?>"><span><span>Опублликовать все</span></span></a>
</div>
<?php endif ?>
<?php foreach ($articles as $article)
        if ($article->photoPost !== null){
?><div class="entry">

    <div class="entry-header clearfix">

        <h1><a class="entry-title" href="<?=$article->url ?>"><?=$article->title ?></a></h1>

        <?php if (!empty($article->photoPost->location_image)):?>
        <div class="where">
            <span>Где:</span>

            <div class="map-box"><a target="_blank" href="<?=$article->photoPost->mapUrl ?>"><img src="<?=$article->photoPost->getImageUrl() ?>"></a></div>
        </div>
        <?php endif ?>

        <div class="meta">

            <div class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $article->created); ?></div>
            <div class="seen">Просмотров:&nbsp;<span id="page_views"><?= PageView::model()->viewsByPath($article->url); ?></span></div>
            <br>
            <a href="<?=$article->url ?>#comment_list">Комментариев: <?php echo $article->commentsCount; ?></a>

        </div>

    </div>

    <div class="entry-content">

        <div class="wysiwyg-content">

            <?=Str::strToParagraph($article->preview) ?>

        </div>

        <div class="morning-images clearfix">
            <div class="big"><img src="<?= $article->photoPost->getPhotoUrl(0) ?>"></div>
            <div class="thumbs">
                <ul>
                    <li><img src="<?= $article->photoPost->getPhotoUrl(1) ?>"></li>
                    <li><img src="<?= $article->photoPost->getPhotoUrl(2) ?>"></li>
                    <?php if (count($article->photoPost->photos) > 3): ?>
                    <li><a href="<?=$article->url ?>" class="more"><i
                        class="icon"></i>еще <?= count($article->photoPost->photos) - 3 ?> фото</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>

    </div>

</div>
<?php } ?>