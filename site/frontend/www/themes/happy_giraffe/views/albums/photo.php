<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.control.js');
?>
<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $photo->author)); ?>
                <p><span><?php echo $photo->author->fullName; ?></span>
                    <?php if($photo->author->country): ?>
                        <br><?php echo $photo->author->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $photo->author->id)) ?></div>
        </div>
    </div>
    <div id="photo">
        <?php if($photo->title != ''): ?>
            <div class="title"><?php echo $photo->title; ?></div>
        <?php endif; ?>

        <div class="big-photo">
            <div class="in">
                <?php $neighboringPhotos = $photo->neighboringPhotos; ?>
                <div class="img"><?php echo CHtml::image($photo->getPreviewUrl(400, 400, Image::HEIGHT)) ?></div>
                <a href="" class="prev"></a>
                <a href="" class="next"></a>
            </div>
        </div>

        <div class="jcarousel-container gallery-photos">
            <div id="photo-thumbs" class="jcarousel">
                <ul>
                    <?php foreach($photo->album->photos as $i => $item): ?>
                        <?php if($photo->id == $item->id) {$selected_item = $i;} ?>
                        <li>
                            <table>
                                <tr>
                                    <td class="img">
                                        <div>
                                            <?php echo CHtml::link(CHtml::image($item->getPreviewUrl(180, 180)), array('/albums/photo', 'id' => $item->id)); ?>
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
</div>

<script type="text/javascript">
    $(function() {
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
        var carousel = $('#photo-thumbs').jcarousel();
        $('#photo-thumbs-prev').jcarouselControl({target: '-=1',carousel: carousel});
        $('#photo-thumbs-next').jcarouselControl({target: '+=1',carousel: carousel});
    });
</script>

<?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => 'Вам понравилось фото?',
    'model' => $photo,
    'options' => array(
        'title' => $photo->description,
        'image' => $item->getPreviewUrl(180, 180),
        'description' => false,
    ),
)); ?>
<?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
    'model' => $photo,
)); ?>