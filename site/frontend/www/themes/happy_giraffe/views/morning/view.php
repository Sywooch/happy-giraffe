<?php
/* @var $this Controller
 * @var $article CommunityContent
 */
?>
<script type="text/javascript">
    var cpo = 0;

    $(window).scroll(function(){

        var cp = $('#checkpoint').offset().top;
        var st = $(window).scrollTop();

        if (!$('#morning').hasClass('morning-wide')) {

            if (st>=cp){
                $('#morning').addClass('morning-wide')
                cpo = cp;
            }

        } else {

            if (st < cpo-100){
                $('#morning').removeClass('morning-wide')
            }

        }
    });
</script>
<div class="entry">

    <div class="entry-header clearfix">

        <h1><?=$article->name ?></h1>

        <div class="where">
            <span>Где:</span>

            <div class="map-box"><a target="_blank" href="<?=$article->photoPost->mapUrl ?>"><img src="<?=$article->photoPost->getImageUrl() ?>"></a></div>
        </div>

        <div class="meta">

            <div
                class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $article->created); ?></div>
            <div class="seen">Просмотров:&nbsp;<span
                id="page_views"><?= PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $article->url), true); ?></span>
            </div>
            <br>
            <a href="#comment_list">Комментариев: <?php echo $article->commentsCount; ?></a>

        </div>

    </div>

    <div class="entry-content">

        <div class="wysiwyg-content">

            <?=Str::strToParagraph($article->preview) ?>

            <?php foreach ($article->photoPost->photos as $photo): ?>
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
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $article,
)); ?>
