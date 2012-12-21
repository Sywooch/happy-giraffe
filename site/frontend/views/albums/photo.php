<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.control.js');
?>
<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div id="photo">
                <?php if((Yii::app()->user->isGuest || $photo->author_id != Yii::app()->user->id) && $photo->title != ''): ?>
                    <div class="title"><?php echo CHtml::encode($photo->title); ?></div>
                <?php elseif(!Yii::app()->user->isGuest && $photo->author_id == Yii::app()->user->id): ?>
                    <div class="title">
                        <span class="album_title"><?php echo $photo->title != '' ? CHtml::encode($photo->title) : '...'; ?></span>
                        <?php echo CHtml::link('', 'javascript:;', array('class' => 'edit tooltip', 'title'=>'Редактировать', 'onclick' => 'return Album.changePhotoTitle(this, ' . $photo->id . ');')); ?>
                    </div>
                <?php endif; ?>

                <div class="big-photo">
                    <div class="in">
                        <?php $neighboringPhotos = $photo->neighboringPhotos; ?>
                        <div class="img"><?php echo CHtml::image($photo->getPreviewUrl(678, 400, Image::WIDTH)) ?></div>
                        <?php if($neighboringPhotos['prev']): ?>
                            <?php echo CHtml::link('<i class="icon"></i>', array('/albums/photo', 'id' => $neighboringPhotos['prev'], 'user_id'=>$photo->author_id, 'album_id'=>$photo->album_id), array('class' => 'prev')); ?>
                        <?php else: ?>
                            <a href="#" class="prev disabled" onclick="return false;"></a>
                        <?php endif; ?>
                        <?php if($neighboringPhotos['next']): ?>
                            <?php echo CHtml::link('<i class="icon"></i>', array('/albums/photo', 'id' => $neighboringPhotos['next'], 'user_id'=>$photo->author_id, 'album_id'=>$photo->album_id), array('class' => 'next')); ?>
                        <?php else: ?>
                            <a href="#" class="next disabled" onclick="return false;"></a>
                        <?php endif; ?>
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
                                                    <?php echo CHtml::link('<img data-src="' . $item->getPreviewUrl(180, 180) . '" alt="" />', $item->url); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="title">
                                            <td align="center">
                                                <div><?php echo $item->title != '' ? CHtml::encode($item->title) : '&nbsp;' ?></div>
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
                <script type="text/javascript">
                    $(function() {
                    <?php if(isset($selected_item)): ?>
                        $('#photo-thumbs').bind('jcarouselinitend', function(carousel) {
                            var count = $('#photo-thumbs li').size();
                            var ready = 0;
                            $('#photo-thumbs img').each(function(){
                                $(this).get(0).onload = function() {
                                    ready++;
                                    if (ready == count) {
                                        $('#photo-thumbs').jcarousel('scroll', <?php echo $selected_item; ?>);
                                    }
                                };
                                $(this).attr('src', $(this).attr('data-src'));
                            });
                        });
                        <?php endif; ?>
                        var carousel = $('#photo-thumbs').jcarousel();
                        $('#photo-thumbs-prev').jcarouselControl({target: '-=1',carousel: carousel});
                        $('#photo-thumbs-next').jcarouselControl({target: '+=1',carousel: carousel});
                    });
                </script>
            </div>
        </div>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'type' => 'minimize',
            'model' => $photo,
            'options' => array(
                'title' => $photo->description,
                'image' => $photo->getPreviewUrl(180, 180),
                'description' => false,
            ),
        )); ?>
        <?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
            'model' => $photo,
            'photoContainer'=>true
        )); ?>
    </div>
</div>

<div class="side-left gallery-sidebar">

    <div class="default-v-nav">
        <div class="title">Мои альбомы </div>
        <ul>
            <?php foreach($photo->album->author->albums('albums:noSystem') as $album): ?>
                <li<?php echo $photo->album->id == $album->id ? ' class="active"' : ''; ?>>
                    <div class="in">
                        <?php echo CHtml::link(CHtml::encode($album->title), $album->url); ?>
                        <span class="count"><?php echo count($album->photos); ?></span>
                        <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

</div>


<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>