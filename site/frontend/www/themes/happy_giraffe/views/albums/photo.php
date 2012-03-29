<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.control.js');
?>
<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div id="photo">
                <?php if($photo->title != ''): ?>
                    <div class="title"><?php echo $photo->title; ?></div>
                <?php endif; ?>

                <div class="big-photo">
                    <div class="in">
                        <?php $neighboringPhotos = $photo->neighboringPhotos; ?>
                        <div class="img"><?php echo CHtml::image($photo->getPreviewUrl(800, 400, Image::WIDTH)) ?></div>
                        <?php if($neighboringPhotos['prev']): ?>
                            <?php echo CHtml::link('', array('/albums/photo', 'id' => $neighboringPhotos['prev']), array('class' => 'prev')); ?>
                        <?php else: ?>
                            <a href="#" class="prev disabled" onclick="return false;"></a>
                        <?php endif; ?>
                        <?php if($neighboringPhotos['next']): ?>
                            <?php echo CHtml::link('', array('/albums/photo', 'id' => $neighboringPhotos['next']), array('class' => 'next')); ?>
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
    </div>
</div>

<div class="side-left gallery-sidebar">

    <div class="default-v-nav">
        <div class="title">Мои альбомы </div>
        <ul>
            <li>
                <div class="in">
                    <a href="">Личные</a>
                    <span class="count">2</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <a href="">Моя семья</a>
                    <span class="count">22</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li class="active">
                <div class="in">
                    <a href="">Поездка в Турцию</a>
                    <span class="count">222</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <a href="">Наша свадьба</a>
                    <span class="count">2</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li class="active">
                <div class="in">
                    <a href="">Дача и все связанное с огородом</a>
                    <span class="count">22</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <a href="">Моя работа</a>
                    <span class="count">22</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <a href="">Мое творчество</a>
                    <span class="count">2</span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
        </ul>

    </div>

</div>

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

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>