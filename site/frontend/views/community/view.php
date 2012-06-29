<?php
/* @var $this CommunityController
 * @var $data CommunityContent
*/
?>

<?php $this->renderPartial('_post', array('data' => $data, 'full' => true)); ?>

<div class="content-more clearfix">
<!--    <big class="title">-->
<!--        Фотографии-->
<!--        --><?php //echo CHtml::link('<span><span>Показать все</span></span>', $data->getUrl() . 'uploadImage/', array('class' => 'btn btn-blue-small')); ?>
<!--    </big>-->

    <big class="title">
        Ещё статьи на эту тему
        <a href="<?php echo CHtml::normalizeUrl($this->getUrl(array('content_type_slug' => null))); ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
    </big>
    <?php
        foreach ($data->relatedPosts as $rc)
        {
            $content = '';
            switch ($rc->type->slug)
            {
                case 'post':
                    if (preg_match('/src="([^"]+)"/', $rc->post->text, $matches)) {
                        $content = '<img src="' . $matches[1] . '" alt="' . CHtml::encode($rc->title) . '" width="150" />';
                    }
                    else
                    {
                        if (preg_match('/<p>(.+)<\/p>/Uis', $rc->post->text, $matches2)) {
                            $content = strip_tags($matches2[1]);
                        }
                    }
                    break;
                case 'travel':
                    if (preg_match('/src="([^"]+)"/', $rc->travel->text, $matches)) {
                        $content = '<img src="' . $matches[1] . '" alt="' . CHtml::encode($rc->title) . '" width="150" />';
                    }
                    else
                    {
                        if (preg_match('/<p>(.+)<\/p>/Uis', $rc->travel->text, $matches2)) {
                            $content = strip_tags($matches2[1]);
                        }
                    }
                    break;
                case 'video':
                    $video = new Video($rc->video->link);
                    $content = '<img src="' . $video->preview . '" alt="' . CHtml::encode($video->title) . '" />';
                    break;
            }
        ?>
            <div class="block">
                <b><?php echo CHtml::link(CHtml::encode($rc->title), $rc->url); ?></b>
                <p><?php echo $content; ?></p>
            </div>
        <?php
        }
    ?>
</div>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $data,
)); ?>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>