<?php
/* @var $this Controller
 * @var $article CommunityContent
 */
?>
<div class="entry">

    <div class="entry-header clearfix">

        <h1><?=$article->title ?></h1>

        <?php if (!empty($article->morningPost->location_image)):?>
            <div class="where">
                <span>Где:</span>

                <div class="map-box"><a target="_blank" href="<?=$article->morningPost->mapUrl ?>"><img src="<?=$article->morningPost->getImageUrl() ?>"></a></div>
            </div>
        <?php endif ?>

        <div class="meta">

            <div
                class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $article->created); ?></div>
            <div class="seen">Просмотров:&nbsp;<span id="page_views"><?= $views = $this->getViews(); ?></span>
                <?php Rating::model()->saveByEntity($article, 'vw', floor($views / 100)); ?>
            </div>
            <br>
            <a href="#comment_list">Комментариев: <?php echo $article->commentsCount; ?></a>

        </div>

    </div>

    <div class="entry-content">

        <div class="wysiwyg-content">

            <?=Str::strToParagraph($article->preview) ?>

            <?php foreach ($article->morningPost->photos as $photo): ?>
            <p><img src="<?=$photo->url ?>" alt=""></p>
            <?=Str::strToParagraph($photo->text) ?>
            <br>
            <?php endforeach; ?>

        </div>

        <div class="entry-footer">

            <div class="admin-actions">

                <?php if (Yii::app()->user->checkAccess('editMorning')): ?>
                    <?php $edit_url = $this->createUrl('morning/edit', array('id' => $article->id)) ?>
                    <?php echo CHtml::link('<i class="icon"></i>', $edit_url, array('class' => 'edit')); ?>

                <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                    'model' => $article,
                    'callback' => 'NewsRemove',
                    'author' => Yii::app()->user->id == $article->author_id
                ));
                    $delete_redirect_url = $this->createUrl('/morning/index');

                Yii::app()->clientScript->registerScript('register_after_removeContent', '
                function NewsRemove() {
                    window.location = "' . $delete_redirect_url . '";}', CClientScript::POS_HEAD);
                ?>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<div class="main">
    <div class="main-in">
        <div class="clearfix">
            <noindex>
                <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                'title' => $article->title,
                'model' => $article,
                'type' => 'simple',
                'options' => array(
                    'title' => CHtml::encode($article->title),
                    'image' => $article->morningPost->getPhoto(),
                    'description' => $article->preview,
                ),
            )); ?>
            </noindex>
        </div>
        <br><br>
        <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
        'model' => $article,
        )); ?>
        <?php
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
        ?>

    </div>
</div>
<?php Yii::app()->clientScript->registerScript('scrolled_content', 'initScrolledContent();'); ?>