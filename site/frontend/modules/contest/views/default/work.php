<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.control.js');
?>

<script type="text/javascript">
    $(function() {
    <?php if(isset($selected_item)): ?>
        $('#photo-thumbs').bind('jcarouselinitend', function(carousel) {
            var count = $('#photo-thumbs li').size();
            var ready = 0;
            $('#photo-thumbs img').each(function(){
                $(this).bind('load', function(){
                    ready++;
                    if (ready == count) $('#photo-thumbs').jcarousel('scroll', <?php echo $selected_item; ?>);
                });
            });
        });
        <?php endif; ?>
        var carousel = $('#photo-thumbs').jcarousel();
        $('#photo-thumbs-prev').jcarouselControl({target: '-=1',carousel: carousel});
        $('#photo-thumbs-next').jcarouselControl({target: '+=1',carousel: carousel});
    });
</script>


<div id="gallery">
    <div class="header clearfix">
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $work->author)); ?>
    </div>

    <div id="photo">
        <?php if($work->title != ''): ?>
            <div class="title"><?php echo $work->title; ?></div>
        <?php endif; ?>

        <div class="big-photo">
            <div class="in">
                <?php $neighboringWorks = $work->neighboringWorks; ?>
                <div class="img"><?php echo CHtml::image($work->photo->photo->getPreviewUrl(400, 400, Image::HEIGHT)) ?></div>
                <?php if($neighboringWorks['prev']): ?>
                    <?php echo CHtml::link('', array('/contest/work', 'id' => $neighboringWorks['prev']), array('class' => 'prev')); ?>
                <?php else: ?>
                    <a href="#" class="prev disabled" onclick="return false;"></a>
                <?php endif; ?>
                <?php if($neighboringWorks['next']): ?>
                    <?php echo CHtml::link('', array('/contest/work', 'id' => $neighboringWorks['next']), array('class' => 'next')); ?>
                <?php else: ?>
                    <a href="#" class="next disabled" onclick="return false;"></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => 'Вам понравилось фото?',
    'model' => $work,
    'options' => array(
        'title' => $work->title,
        'image' => $work->photo->photo->getPreviewUrl(180, 180),
        'description' => false,
    ),
    )); ?>

    <div class="content-title">
        Последние добавленные работы
        <?php echo CHtml::link('<span><span>Показать все</span></span>', array('/contest/list/' . $this->contest->contest_id), array(
        'class' => 'btn btn-blue-small'
    )); ?>
    </div>

    <div class="jcarousel-container gallery-photos">
        <div id="photo-thumbs" class="jcarousel">
            <ul>
                <?php foreach($work->contest->works as $i => $item): ?>
                    <?php if($work->id == $item->id) {$selected_item = $i;} ?>
                    <li>
                        <table>
                            <tr>
                                <td class="img">
                                    <div>
                                        <?php echo CHtml::link(CHtml::image($item->photo->photo->getPreviewUrl(180, 180)), array('/contest/work', 'id' => $item->id)); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="title">
                                <td align="center">
                                    <div><?php echo $item->title; ?></div>
                                </td>
                            </tr>
                        </table>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a id="photo-thumbs-prev" class="prev" href="#"></a>
        <a id="photo-thumbs-next" class="next" href="#"></a>

    </div>
</div>

<?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
    'model' => $work,
)); ?>


<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>